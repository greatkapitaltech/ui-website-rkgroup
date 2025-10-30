<?php
/**
 * CodeIgniter 4 Database Config Diagnostic
 * This shows what Database.php is actually loading
 */

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

// Load our paths config file
require FCPATH . 'app/Config/Paths.php';
$paths = new Config\Paths();

// Location of the framework bootstrap file.
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load environment settings from .env files
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

// Define ENVIRONMENT
if (! defined('ENVIRONMENT')) {
    define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));
}

echo "<h2>CodeIgniter 4 Database Configuration Diagnostic</h2>";
echo "<pre>";

echo "Environment: " . ENVIRONMENT . "\n\n";

// Check getenv values
echo "Raw getenv() values:\n";
echo "-------------------\n";
echo "database.default.hostname: " . (getenv('database.default.hostname') ?: 'NOT SET') . "\n";
echo "database.default.database: " . (getenv('database.default.database') ?: 'NOT SET') . "\n";
echo "database.default.username: " . (getenv('database.default.username') ?: 'NOT SET') . "\n";
echo "database.default.password: " . (getenv('database.default.password') ? str_repeat('*', strlen(getenv('database.default.password'))) : 'NOT SET') . "\n";
echo "database.default.password length: " . strlen(getenv('database.default.password')) . " characters\n\n";

// Load Database config
$config = new \Config\Database();

echo "Database.php \$default array:\n";
echo "-----------------------------\n";
echo "hostname: " . $config->default['hostname'] . "\n";
echo "database: " . $config->default['database'] . "\n";
echo "username: " . $config->default['username'] . "\n";
echo "password: " . str_repeat('*', strlen($config->default['password'])) . " (" . strlen($config->default['password']) . " chars)\n";
echo "DBDriver: " . $config->default['DBDriver'] . "\n\n";

// Check if password matches
$envPass = getenv('database.default.password');
$configPass = $config->default['password'];

if (empty($configPass)) {
    echo "❌ ERROR: Database password is EMPTY in Database.php!\n";
    echo "   This means Database.php is NOT loading from .env file.\n\n";
    echo "   Action: Upload the updated Database.php file to production!\n";
} elseif ($envPass === $configPass) {
    echo "✓ Password matches .env file!\n\n";

    // Test actual connection
    echo "Testing MySQL connection with CodeIgniter config:\n";
    echo "-------------------------------------------------\n";
    try {
        $conn = new mysqli(
            $config->default['hostname'],
            $config->default['username'],
            $config->default['password'],
            $config->default['database']
        );

        if ($conn->connect_error) {
            echo "❌ Connection failed: " . $conn->connect_error . "\n";
        } else {
            echo "✓ Connection successful!\n";
            echo "✓ MySQL version: " . $conn->server_info . "\n";
            $conn->close();
        }
    } catch (Exception $e) {
        echo "❌ ERROR: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ Password MISMATCH!\n";
    echo "   .env password: " . strlen($envPass) . " chars\n";
    echo "   Config password: " . strlen($configPass) . " chars\n";
}

echo "</pre>";

echo "<hr>";
echo "<h3>Diagnosis:</h3>";
if (empty($configPass)) {
    echo "<p style='color: red; font-weight: bold;'>⚠️ Database.php is NOT reading from .env file!</p>";
    echo "<p><strong>Solution:</strong> Upload the updated Database.php file from your local installation.</p>";
    echo "<p>File to upload: <code>app/Config/Database.php</code></p>";
} else {
    echo "<p style='color: green;'>✓ Database.php is reading from .env correctly</p>";
}

echo "<p><strong>DELETE THIS FILE after testing for security!</strong></p>";
?>
