<?php
define('web_root', __DIR__);
define('app', __DIR__);
define('DS', DIRECTORY_SEPARATOR);

spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();


require 'config.php';
$cfg = Config::getInstance();
$cfg->setDebug(true);
# error reporting
if ($cfg->isDebug()) {
    ini_set('error_log', app . '/error.log');
    ini_set('log_errors', 'On');
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
} else {
    ini_set('error_log', app . '/error.log');
    ini_set('log_errors', 'On');
    ini_set('display_errors', 'Off');
    error_reporting(E_ERROR);
}

session_start();

# routing
require app . DS . 'vendor' . DS . 'alto-router.php';

$router = new AltoRouter();
$router->setBasePath('');

# default controller
$router->map('GET', '/', function ($params) {
    $obj = new \controller\home_controller();
    $obj->index();
});

# rest of the controllers for this file simplicity moved to routes.php
require 'routes.php';
mapAllRoutes($router);

$match = $router->match();
if ($match === false) {
    # route not found
    require '404.php';
    return;
}
# run the closure from the routes array
if ($cfg->isRelease()) {
    try {
        $match['target']($match['params']);
    } catch (Exception $e) {
        require '500.php';
    }
} else {
    $match['target']($match['params']);
}


