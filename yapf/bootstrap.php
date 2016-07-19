<?php
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

# generic error pages for production
function show404()
{
    require web_root . DS . '404.php';
}

function show500()
{
    require web_root . DS . '500.php';
}

class BadRouteException extends \Exception
{
}

use app\controller;
use yapf\Config;
use yapf\plugin\AltoRouter;


# autoload every class obeying the PS-0 namespace standard.
# For example app\controller\x_controller.php should be named
# namespace app\controller;
# class x_controller.php { ... }
spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();


$cfg = Config::getInstance();
if (file_exists(app_config . 'configuration.php')) {
    require app_config . 'configuration.php';
    app_configure($cfg);
}


# error reporting configuration
ini_set('error_log', app_log . 'error.log');
ini_set('log_errors', 'On');
error_reporting(E_ALL);
if ($cfg->isDebug()) {
    ini_set('display_errors', 'On');
} else {
    ini_set('display_errors', 'Off');
}

/**
 * @param $params array containing  action, controller, and params keys
 * $params = [
 * 'controller' => 'home',
 * 'action'     => 'index',
 * 'params'     => ['id' => 1 ]
 * ]
 */
function standard_router(array $params)
{
    $controller = "\\app\\controller\\" . $params['controller'] . "_controller";
    $action = empty($params['action']) ? 'index' : $params['action'];
    if (file_exists(substr($controller, 1) . '.php')) {
        /** @var \yapf\controller $obj */
        $obj = new $controller();
        if (is_callable([$obj, $action])) {
            $obj->setParams($params);
            call_user_func_array([$obj, $action], [$params]);
        } else {
            if (\yapf\Config::getInstance()->isDebug()) {
                throw new BadMethodCallException("method $action not found in $controller");
            }
            show404();
        }
    } else {
        show404();
    }
}

# routing
$router = new AltoRouter();
$router->setBasePath('');

# default controller
$router->map('GET', '/', function () {
    $obj = new controller\home_controller();
    $obj->index();
});

# user configured routes
require app_config . 'routes.php';
app_map_routes($router);

$match = $router->match();
if ($match === false) {
    # route not found
    show404();
    return;
}
session_start();
# runs the closures from the routes array
if (is_null($match['target']) || empty($match['target'])) {
    standard_router($match['params']);
} else if (is_callable($match['target'])) {
    $match['target']($match['params']);
} else {
    show500();
    throw new BadRouteException("No function to call, check your routes.php file");
}
