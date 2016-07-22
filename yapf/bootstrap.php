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
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
    require web_root . DS . '404.php';
}

function show500()
{
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    require web_root . DS . '500.php';
}

# fires when there is something wrong with routes.php file
class BadRouteException extends \Exception
{
}

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
 * @throws BadRouteException
 */
function standard_route($controller, $action = 'index', $params = [])
{
    $controller = "\\app\\controller\\" . $controller . "_controller";

    if (file_exists(str_replace("\\", DS, substr($controller, 1)) . '.php')) {
        require str_replace("\\", DS, substr($controller, 1)) . '.php';
        /** @var \yapf\controller $obj */
        $obj = new $controller();

        if (is_callable([$obj, $action])) {
            $rq = \yapf\Request::standard($params);
            $obj->setRequestData($rq);
            $obj->$action($rq);
        } else {
            show404();
            if (\yapf\Config::getInstance()->isDebug()) {
                throw new BadRouteException("method $action not found in $controller");
            }
        }
    } else {
        show404();
        throw new BadRouteException("No controller with name: [$controller]");
    }
}

# routing
$router = new AltoRouter();
$router->setBasePath('');

# default route/index page
$router->map('GET', '/', function () {
    $controller = Config::getInstance()->getDefaultController();
    standard_route($controller, 'index', []);
});

# user configured routes
require app_config . 'routes.php';
app_map_routes($router);
# to allow links like /home/ not only /home
$requestUrl = isset($_SERVER['REQUEST_URI']) ? rtrim($_SERVER['REQUEST_URI'], '/') : '/';
if (empty($requestUrl)) {
    $requestUrl = '/';
}
$match = $router->match($requestUrl);
if ($match === false) {
    # route not found
    show404();
    return;
}
session_start();
# runs the closures from the routes array
if (empty($match['target'])) {
    $params = $match['params'];
    $controller = $params['controller'];
    $action = isset($params['action']) ? $params['action'] : 'index';
    standard_route($controller, $action, $params);
} else if (is_callable($match['target'])) {
    $match['target']($match['params']);
} else if (($pos = strpos($match['target'], '#')) !== false) {
    $controller = substr($match['target'], 0, $pos);
    $action = substr($match['target'], $pos + 1);
    standard_route($controller, $action, $match['params']);
} else {
    show500();
    throw new BadRouteException("No function to call, check your routes.php file");
}
