<?php
// Test Database Connection
// Upload to: /home4/tempucqs/public_html/rkgroup.biz/new_site/testdb.php
// Visit: https://rkgroup.biz/new_site/testdb.php

$host = "localhost";
$username = "tempucqs_rkgroup_new_website";
$password = "TzA!&xgx[plp\\";
$database = "tempucqs_rkgroup_new_website";

echo "<h2>Database Connection Test</h2>";

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    echo "<p style='color: red;'>❌ Connection failed: " . $mysqli->connect_error . "</p>";
    exit;
}

echo "<p style='color: green;'>✅ Database connected successfully!</p>";

// Test tables
$tables = ['admin', 'companies', 'partners', 'board_members', 'contact_submissions', 'site_settings', 'news_items'];

echo "<h3>Tables Check:</h3><ul>";
foreach ($tables as $table) {
    $result = $mysqli->query("SHOW TABLES LIKE '$table'");
    if ($result && $result->num_rows > 0) {
        $count = $mysqli->query("SELECT COUNT(*) as cnt FROM $table")->fetch_assoc()['cnt'];
        echo "<li style='color: green;'>✅ Table <strong>$table</strong> exists ($count records)</li>";
    } else {
        echo "<li style='color: red;'>❌ Table <strong>$table</strong> NOT found</li>";
    }
}
echo "</ul>";

$mysqli->close();

echo "<hr>";
echo "<h3>PHP Info:</h3>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>MySQLi Extension: " . (extension_loaded('mysqli') ? '✅ Enabled' : '❌ Disabled') . "</p>";
echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";

echo "<hr>";
echo "<p><strong>⚠️ Delete this file after testing!</strong></p>";
