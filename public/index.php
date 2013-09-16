<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// echo (dirname(__DIR__))."</br>";
// echo php_sapi_name() ."</br>";
// print_r( __DIR__ );
// echo "</br>";
// print_r(parse_url($_SERVER['REQUEST_URI']));
// echo "</br>";
// var_dump ( PHP_URL_PATH);
// echo "</br>";
// var_dump( is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) );
// die;

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
