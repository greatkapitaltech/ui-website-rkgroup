<?php
/**
 * Database Connection Test Script
 * Upload this to your production server root and access via browser
 */

echo "<h2>Database Connection Test</h2>";
echo "<pre>";

// Read .env file
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    echo "✓ .env file found\n\n";

    $envContent = file_get_contents($envFile);

    // Extract database credentials
    preg_match('/database\.default\.hostname\s*=\s*(.+)/i', $envContent, $hostname);
    preg_match('/database\.default\.database\s*=\s*(.+)/i', $envContent, $database);
    preg_match('/database\.default\.username\s*=\s*(.+)/i', $envContent, $username);
    preg_match('/database\.default\.password\s*=\s*["\']?(.+?)["\']?\s*$/im', $envContent, $password);

    $host = trim($hostname[1] ?? '');
    $db = trim($database[1] ?? '');
    $user = trim($username[1] ?? '');
    $pass = trim($password[1] ?? '', '"\'');

    echo "Database Credentials from .env:\n";
    echo "--------------------------------\n";
    echo "Hostname: $host\n";
    echo "Database: $db\n";
    echo "Username: $user\n";
    echo "Password: " . str_repeat('*', strlen($pass)) . " (" . strlen($pass) . " characters)\n\n";

    // Test connection
    echo "Testing connection...\n";
    echo "--------------------------------\n";

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $conn = new mysqli($host, $user, $pass, $db);

        if ($conn->connect_error) {
            echo "❌ Connection failed: " . $conn->connect_error . "\n";
        } else {
            echo "✓ Connection successful!\n";
            echo "✓ MySQL Server version: " . $conn->server_info . "\n";
            echo "✓ Connected to database: $db\n";

            // Test query
            $result = $conn->query("SHOW TABLES");
            if ($result) {
                echo "\n✓ Tables in database:\n";
                while ($row = $result->fetch_array()) {
                    echo "  - " . $row[0] . "\n";
                }
            }

            $conn->close();
        }
    } catch (Exception $e) {
        echo "❌ ERROR: " . $e->getMessage() . "\n\n";

        echo "Common Issues:\n";
        echo "1. Wrong password - Check cPanel MySQL users\n";
        echo "2. User not assigned to database - Check cPanel MySQL databases\n";
        echo "3. Password contains special characters - Check escaping in .env\n";
    }

} else {
    echo "❌ .env file not found at: $envFile\n";
}

echo "</pre>";

echo "<hr>";
echo "<h3>Action Items:</h3>";
echo "<ol>";
echo "<li>If connection fails, check your cPanel MySQL settings</li>";
echo "<li>Verify the database user exists in cPanel > MySQL Databases</li>";
echo "<li>Ensure the user is assigned to the database with ALL PRIVILEGES</li>";
echo "<li>Check if the password in .env matches cPanel exactly</li>";
echo "<li><strong>DELETE THIS FILE after testing for security!</strong></li>";
echo "</ol>";
?>
