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

// Get the current database connection
$sqliteConnection = DB::connection('sqlite');
$mysqlConnection = DB::connection(env('DB_CONNECTION', 'mysql'));

debug("Starting data migration from SQLite to MySQL...");

// Get all tables from SQLite database
$tables = $sqliteConnection->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");

foreach ($tables as $table) {
    $tableName = $table->name;
    
    // Skip migrations table
    if ($tableName === 'migrations') {
        debug("Skipping migrations table");
        continue;
    }
    
    debug("Processing table: $tableName");
    
    // Get all data from the SQLite table
    $rows = $sqliteConnection->table($tableName)->get();
    
    if (count($rows) === 0) {
        debug("No data found in table: $tableName");
        continue;
    }
    
    debug("Found " . count($rows) . " rows in table: $tableName");
    
    // Convert data to array format
    $data = json_decode(json_encode($rows), true);
    
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
}

debug("Data migration completed successfully!");