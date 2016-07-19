<?php
# generic error pages for production
function show404()
{
    require web_root . DS . '404.php';
}

function show500()
{
    require web_root . DS . '500.php';
}

use app\controller;
use yapf\Config;
use yapf\plugin\AltoRouter;


define('DS', DIRECTORY_SEPARATOR);
define('web_root', dirname(__DIR__) . DS);
define('app', dirname(__DIR__) . DS . 'app' . DS);
define('app_controller', app . 'controller' . DS);
define('app_helper', app . 'helper' . DS);
define('app_config', app . 'config' . DS);
define('app_view', app . 'view' . DS);
define('app_model', app . 'model' . DS);
define('app_plugin', app . 'plugin' . DS);
define('app_log', app . 'log' . DS);


# autoload every class obeying the PS-0 namespace standard.
# For example app\controller\x_controller.php should be named
# namespace app\controller;
# class x_controller.php { ... }
spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();


$cfg = Config::getInstance();
# error reporting configuration
ini_set('error_log', app_log . 'error.log');
ini_set('log_errors', 'On');
if ($cfg->isDebug()) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 'Off');
    error_reporting(0);
}


require app_config . 'configuration.php';
app_configure($cfg);


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
require app_config . 'routes.php';
app_map_routes($router);

$match = $router->match();
if ($match === false) {
    # route not found
    show404();
    return;
}
# runs the closures from the routes array
$match['target']($match['params']);
