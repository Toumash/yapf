<?php
/*
 * http://altorouter.com/usage/mapping-routes.html
 * For standard router handling (needed controller && action in route) use null as target)
 * If you provide other string then function with such name will be called
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
use @ (at) to provide your own regex
 */
function app_map_routes(yapf\plugin\AltoRouter $router)
{
    # routes are executed in mappings order - place the most generic at the END

    # example route
    $router->map('GET|POST|DELETE', '/RoutingCheck', 'custom_router');

    $router->map('GET|POST|DELETE', '/RoutingCheck/[i:id]?/[a:name]?', 'custom_router');

    # routes are executed in mappings order - place the most generic at the END
    # default route. Usually will suffice, so don't remove unless you know what are you doing
    $router->map('GET|POST|DELETE', '/[a:controller]/[a:action]?/[a:id]?', null);
}

function custom_router($params)
{
    $obj = new \app\controller\example_controller();
    $obj->setParams($params);
    $action = 'selfCheck';
    if (is_callable([$obj, $action])) {
        $rq = \yapf\Request::standard($params);
        $obj->$action($rq);
    } else {
        if (\yapf\Config::getInstance()->isDebug()) {
            throw new BadMethodCallException("method $action not found in {$obj->getControllerName()}");
        }
        show404();
    }
}