<?php
define('DS', DIRECTORY_SEPARATOR);
define('web_root', __DIR__);
define('app', __DIR__ . DS . 'app');

# generic error pages for production
function show404()
{
    require app . DS . '404.php';
}

function show500()
{
    require app . DS . '500.php';
}

# autoload every class obeying the PS-0 namespace standard.
# For example app\controller\x_controller.php should be named
# namespace app\controller;
# class x_controller.php { ... }
spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();


use app\Config;
use app\controller;
use app\vendor\AltoRouter;

$cfg = Config::getInstance();
$cfg->setDebug(true);

# error reporting configuration
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
$router = new AltoRouter();
$router->setBasePath('');

# default controller
$router->map('GET', '/', function () {
    $obj = new controller\home_controller();
    $obj->index();
});

# rest of the controllers for this file simplicity moved to routes.php
require app . DS . 'config' . DS . 'routes.php';
mapAllRoutes($router);

$match = $router->match();
if ($match === false) {
    # route not found
    show404();
    return;
}
# run the closure from the routes array
if ($cfg->isRelease()) {
    try {
        $match['target']($match['params']);
    } catch (Exception $e) {
        show500();
    }
} else {
    $match['target']($match['params']);
}