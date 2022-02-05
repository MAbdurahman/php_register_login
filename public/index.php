<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
?>

<?php

    /**
     * Front controller
     * PHP version 8.0.13
     */

    // composer autoload
    require dirname(__DIR__) . '/vendor/autoload.php';

    // twig
    Twig_Autoloader::register();

    // vlucas/phpdotenv
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    // error and exception handling
    error_reporting(E_ALL);
    set_error_handler('core\Error::errorHandler');
    set_exception_handler('core\Error::exceptionHandler');


    /**
     * Autoloader
     */
/*    spl_autoload_register(function ($class) {
        $root = dirname(__DIR__);   // get the parent directory
        $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
        if (is_readable($file)) {
            require $root . '/' . str_replace('\\', '/', $class) . '.php';
        }
    });*/

    // routing
    $router = new core\Router();

    // Add the routes
    $router->add('', ['controller' => 'Home', 'action' => 'index']);
    $router->add('{controller}/{action}');
    $router->add('{controller}/{id:\d+}/{action}');
    $router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
    
    $router->dispatch($_SERVER['QUERY_STRING']);


