<?php
// -----------------------------------------------------------------------------
// Remove 'index.php' from REQUEST_URI for cleaner URLs.
// This ensures that URLs do not include 'index.php', improving readability
// and usability of the application.
// -----------------------------------------------------------------------------
$_SERVER["REQUEST_URI"] = str_replace('index.php', '', $_SERVER["REQUEST_URI"]);

// -----------------------------------------------------------------------------
// Set localization settings for date and time functions.
// These settings ensure that date and time functions use the correct locale
// and character encoding for Brazilian Portuguese.
// -----------------------------------------------------------------------------
setlocale(LC_TIME, 'ptb', 'pt_BR', 'portuguese-brazil', 'bra', 'brazil', 'pt_BR.utf-8', 'pt_BR.iso-8859-1', 'br');
setlocale(LC_CTYPE, 'pt_BR');

// Set the default timezone to São Paulo, Brazil.
date_default_timezone_set('America/Sao_Paulo');

// -----------------------------------------------------------------------------
// Force UTF-8 encoding for the response.
// This ensures that all output from the script is encoded in UTF-8, which
// helps prevent character encoding issues in the browser.
// -----------------------------------------------------------------------------
header("Content-Type: text/html; charset=utf-8");

// -----------------------------------------------------------------------------
// Configure session settings.
// These settings extend the session lifetime to 10 hours (36000 seconds),
// ensuring that users remain logged in for longer periods.
// -----------------------------------------------------------------------------
ini_set('session.gc_maxlifetime', 36000);
session_set_cookie_params(36000);

// -----------------------------------------------------------------------------
// Set error reporting level.
// This configuration suppresses warnings, notices, and strict standards
// messages. It is recommended to show all errors in a development environment
// for easier debugging.
// -----------------------------------------------------------------------------
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_STRICT);

// -----------------------------------------------------------------------------
// Define the application path.
// This constant defines the path to the application directory, which contains
// the main application code.
// -----------------------------------------------------------------------------
defined("APPLICATION_PATH") || define("APPLICATION_PATH", dirname(__FILE__) . "/src");

// -----------------------------------------------------------------------------
// Define the application environment.
// This constant sets the environment for the application (e.g., production,
// development). It defaults to 'production' if not set.
// -----------------------------------------------------------------------------
defined("APPLICATION_ENV") || define("APPLICATION_ENV", (getenv("APPLICATION_ENV") ? getenv("APPLICATION_ENV") : "production"));

// -----------------------------------------------------------------------------
// Ensure that the library and modules directories are on the include path.
// This allows the application to autoload classes from these directories.
// -----------------------------------------------------------------------------
set_include_path(implode(PATH_SEPARATOR, array(
    APPLICATION_PATH . "/../utils",
    APPLICATION_PATH . "/modules",
    get_include_path(),
)));

// -----------------------------------------------------------------------------
// Include the main application class and helper functions.
// These files contain the core logic and helper functions for the application.
// -----------------------------------------------------------------------------
require_once("utils/gazetamarista/Application.php");
require_once("utils/gazetamarista/_helpers.php");

// -----------------------------------------------------------------------------
// Create, bootstrap, and run the application.
// This initializes the application with the specified environment and
// configuration, then starts the application.
// -----------------------------------------------------------------------------
$application = new gazetamarista_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . "/configs/custom_config.ini"
);

$application->bootstrap()->run();
