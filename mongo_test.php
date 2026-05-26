<?php
require 'vendor/autoload.php';
$uri = "mongodb+srv://learning_group:lkjhg%2F321@cluster0.0af3gbj.mongodb.net/?appName=Cluster0";
$client = new MongoDB\Client($uri);
try {
    $dbs = $client->listDatabases();
    echo "Connected successfully. Databases:\n";
    foreach ($dbs as $db) {
        echo "- " . $db->getName() . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
