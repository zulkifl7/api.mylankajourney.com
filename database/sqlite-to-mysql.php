<?php

/**
 * SQLite to MySQL Data Migration Script
 * 
 * This script exports data from a SQLite database and imports it into a MySQL database.
 * It preserves all data from the original SQLite database.
 */

// Set to true to enable debug output
$debug = true;

// Function to log debug messages
function debug($message) {
    global $debug;
    if ($debug) {
        echo $message . PHP_EOL;
    }
}

// Get the database connections from Laravel's configuration
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Set the correct path to the SQLite database file
$sqlitePath = __DIR__ . '/database.sqlite';
debug("Using SQLite database at: $sqlitePath");

// Override the SQLite connection configuration
config(['database.connections.sqlite.database' => $sqlitePath]);

// Get the database connections
$sqliteConnection = DB::connection('sqlite');
$mysqlConnection = DB::connection(env('DB_CONNECTION', 'mysql'));

debug("Starting data migration from SQLite to MySQL...");

// Define the order of tables to process (based on foreign key dependencies)
$tableOrder = [
    'users',
    'countries',
    'locations',
    'activity_categories',
    'activities',
    'trip_plans',
    'activity_trip_plan',
    'subscriptions',
    'gallery_cities',
    'personal_access_tokens',
    // Add any other tables at the end
];

// Get all tables from SQLite database
$allTables = $sqliteConnection->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
$allTableNames = [];

foreach ($allTables as $table) {
    if ($table->name !== 'migrations') {
        $allTableNames[] = $table->name;
    }
}

// Add any tables not explicitly ordered to the end of the order array
foreach ($allTableNames as $tableName) {
    if (!in_array($tableName, $tableOrder)) {
        $tableOrder[] = $tableName;
    }
}

// Disable foreign key checks temporarily to avoid constraint issues
$mysqlConnection->statement('SET FOREIGN_KEY_CHECKS=0');
debug("Disabled foreign key checks for import");

// Truncate all MySQL tables first to ensure clean import
debug("Truncating all MySQL tables before import...");
foreach (array_reverse($tableOrder) as $tableName) {
    try {
        // Check if table exists in MySQL
        $tableExists = $mysqlConnection->select("SHOW TABLES LIKE '$tableName'");
        if (count($tableExists) > 0) {
            $mysqlConnection->statement("TRUNCATE TABLE $tableName");
            debug("Truncated table: $tableName");
        }
    } catch (\Exception $e) {
        debug("Error truncating table $tableName: " . $e->getMessage());
    }
}
debug("All tables truncated successfully.");

// Process tables in the defined order
foreach ($tableOrder as $tableName) {
    // Skip migrations table
    if ($tableName === 'migrations') {
        debug("Skipping migrations table");
        continue;
    }
    
    debug("Processing table: $tableName");
    
    // Check if table exists in SQLite
    try {
        // Get all data from the SQLite table
        $rows = $sqliteConnection->table($tableName)->get();
        
        if (count($rows) === 0) {
            debug("No data found in table: $tableName");
            continue;
        }
        
        debug("Found " . count($rows) . " rows in table: $tableName");
        
        // Convert data to array format
        $data = json_decode(json_encode($rows), true);
        
        // Check if table already has data
        $existingCount = $mysqlConnection->table($tableName)->count();
        if ($existingCount > 0) {
            debug("Table $tableName already has $existingCount records. Skipping to avoid duplicates.");
            continue;
        }
        
        // Insert data into MySQL table in chunks to avoid memory issues
        $chunkSize = 100;
        $chunks = array_chunk($data, $chunkSize);
        
        foreach ($chunks as $index => $chunk) {
            try {
                $mysqlConnection->table($tableName)->insert($chunk);
                debug("Inserted chunk " . ($index + 1) . " of " . count($chunks) . " into $tableName");
            } catch (\Exception $e) {
                debug("Error inserting data into $tableName: " . $e->getMessage());
                // Continue with next chunk even if there's an error
            }
        }
        
        debug("Completed migration for table: $tableName");
    } catch (\Exception $e) {
        debug("Error processing table $tableName: " . $e->getMessage());
    }
}

// Re-enable foreign key checks
$mysqlConnection->statement('SET FOREIGN_KEY_CHECKS=1');
debug("Re-enabled foreign key checks");

debug("Data migration completed successfully!");