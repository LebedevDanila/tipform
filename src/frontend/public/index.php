<?php


if( ! file_exists('../.env'))
{
    file_put_contents('../.env', $_ENV['CONFIG_MAP'], 0777);
}


// Valid PHP Version?
$minPHPVersion = '7.2';
if (phpversion() < $minPHPVersion)
{
	die("Your PHP version must be {$minPHPVersion} or higher to run CodeIgniter. Current version: " . phpversion());
}
unset($minPHPVersion);

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Location of the Paths config file.
// This is the line that might need to be changed, depending on your folder structure.
$pathsPath = realpath(FCPATH . '../app/Config/Paths.php');
// ^^^ Change this if you move your application folder

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// Ensure the current directory is pointing to the front controller's directory
chdir(__DIR__);

// Load our paths config file
require $pathsPath;
$paths = new Config\Paths();

// Location of the framework bootstrap file.
$app = require realpath(rtrim($paths->systemDirectory, '/ ') . '/bootstrap.php');

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is setup, it's time to actually fire
 * up the engines and make this app do its thang.
 */
$app->run();

$subject = $_SERVER["REQUEST_URI"];

$pattern = '/\/\/+/';
$count_replace = 0;
$replaced_url = preg_replace($pattern, '/', $subject, -1, $count_replace);
if ($count_replace > 0) {
    header('Location: /');
}

$pattern = '/index\.php/';
$count_replace = 0;
$replaced_url = preg_replace($pattern, '/', $subject, -1, $count_replace);
if ($count_replace > 0) {
    header('Location: /');
}