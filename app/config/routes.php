<?php
use app\Config;
use app\controller;
// http://altorouter.com/usage/mapping-routes.html
/*
*                    // Match all request URIs
[i]                  // Match an integer
[i:id]               // Match an integer as 'id'
[a:action]           // Match alphanumeric characters as 'action'
[h:key]              // Match hexadecimal characters as 'key'
[:action]            // Match anything up to the next / or end of the URI as 'action'
[create|edit:action] // Match either 'create' or 'edit' as 'action'
[*]                  // Catch all (lazy, stops at the next trailing slash)
[*:trailing]         // Catch all as 'trailing' (lazy)
[**:trailing]        // Catch all (possessive - will match the rest of the URI)
.[:format]?          // Match an optional parameter 'format' - a / or . before the block is also optional
 */
/**
 * @param $params array containing  action, controller, and params keys
 * $params = [
 * 'controller' => 'home',
 * 'action'     => 'index',
 * 'params'     => ['id' => 1 ]
 * ]
 */
function standardDispatcher(array $params)
{
    $controller = "\\app\\controller\\" . $params['controller'] . "_controller";
    $action = empty($params['action']) ? 'index' : $params['action'];
    if (file_exists(substr($controller, 1) . '.php')) {
        /** @var controller\controller $obj */
        $obj = new $controller();
        if (is_callable([$obj, $action])) {
            $obj->setParams($params);
            call_user_func_array([$obj, $action], [$params]);
        } else {
            if (Config::getInstance()->isDebug()) {
                throw new BadMethodCallException("method $action not found in $controller");
            }
            show404();
        }
    } else {
        show404();
    }
}
use app\plugin\AltoRouter;

function mapAllRoutes(AltoRouter $router)
{
    $router->map('GET|POST|DELETE', '/[a:controller]/[a:action]?/[a:id]?', 'standardDispatcher');
}