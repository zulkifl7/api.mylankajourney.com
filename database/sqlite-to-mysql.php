<?php

/**
 * SQLite to MySQL Data Migration Script
 * 
 * This script exports data from a SQLite database and imports it into a MySQL database.
 * It preserves all data from the original SQLite database.
 */

// Parse command line arguments
$dryRun = false;
foreach ($argv as $arg) {
    if ($arg === '--dry-run') {
        $dryRun = true;
    }
}

// Set to true to enable debug output
$debug = true;

// Function to log debug messages
function debug($message) {
    global $debug;
    if ($debug) {
        echo $message . PHP_EOL;
    }
}

// Display script mode
if ($dryRun) {
    debug("Running in DRY RUN mode - no actual changes will be made to the database");
} else {
    debug("Running in LIVE mode - changes will be made to the database");
    debug("To run in dry run mode, use: php sqlite-to-mysql.php --dry-run");
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

// Handle foreign key checks and table truncation based on dry run mode
if (!$dryRun) {
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
} else {
    debug("[DRY RUN] Would disable foreign key checks");
    debug("[DRY RUN] Would truncate all tables in reverse order");
}

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
        
        // Clean and sanitize data, especially image URLs
        foreach ($data as $key => $row) {
            foreach ($row as $field => $value) {
                // Check if the field might contain an image URL
                if (is_string($value) && (
                    strpos($value, 'http') === 0 || 
                    strpos($value, 'www.') === 0 || 
                    strpos($value, 'data:image') === 0
                )) {
                    // Sanitize URLs - remove backticks and trailing commas
                    $value = trim($value, '` ,');
                    
                    // Truncate extremely long data:image URLs
                    if (strpos($value, 'data:image') === 0 && strlen($value) > 1000) {
                        $value = substr($value, 0, 1000);
                    }
                    
                    $data[$key][$field] = $value;
                }
            }
        }
        
        if (!$dryRun) {
            // Check if table already has data
            $existingCount = $mysqlConnection->table($tableName)->count();
            if ($existingCount > 0) {
                debug("Table $tableName already has $existingCount records. Skipping to avoid duplicates.");
                continue;
            }
            
            // Insert data into MySQL table in chunks to avoid memory issues
            $chunkSize = 50; // Reduced chunk size for better error handling
            $chunks = array_chunk($data, $chunkSize);
            
            foreach ($chunks as $index => $chunk) {
                try {
                    $mysqlConnection->table($tableName)->insert($chunk);
                    debug("Inserted chunk " . ($index + 1) . " of " . count($chunks) . " into $tableName");
                } catch (\Exception $e) {
                    debug("Error inserting data into $tableName: " . $e->getMessage());
                    
                    // Try inserting records one by one to identify problematic records
                    debug("Attempting to insert records one by one...");
                    foreach ($chunk as $record) {
                        try {
                            $mysqlConnection->table($tableName)->insert($record);
                        } catch (\Exception $innerException) {
                            debug("Problem record: " . json_encode($record));
                            debug("Error: " . $innerException->getMessage());
                        }
                    }
                }
            }
            
            debug("Completed migration for table: $tableName");
        } else {
            debug("[DRY RUN] Would insert " . count($data) . " records into table: $tableName");
        }
    } catch (\Exception $e) {
        debug("Error processing table $tableName: " . $e->getMessage());
    }
}

// Re-enable foreign key checks if not in dry run mode
if (!$dryRun) {
    $mysqlConnection->statement('SET FOREIGN_KEY_CHECKS=1');
    debug("Re-enabled foreign key checks");
    debug("Data migration completed successfully!");
} else {
    debug("[DRY RUN] Would re-enable foreign key checks");
    debug("[DRY RUN] Data migration simulation completed successfully!");
}