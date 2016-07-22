<?php

namespace yapf;


class Request
{
    /**
     * @var array
     */
    private $routeParams;
    /**
     * @var array
     */
    private $getParams;
    /**
     * @var array
     */
    private $postParams;

    public function __construct(array $routeParams, array $get, array $post)
    {
        $this->routeParams = $routeParams;
        $this->getParams = $get;
        $this->postParams = $post;
    }

    /**
     * Standard routed way to create request to pass to yapf framework controllers methods
     * @param array $params routed argumets
     */
    public static function standard(array $params)
    {
        return new Request($params, $_GET, $_POST);
    }

    /**
     * @param $key string key in the $_GET array. If null then the whole array is returned
     * @param mixed $default fallback value, if nothing specified and key does not exists - throws Exception
     * @return mixed if key exist it returns data from the $_GET super global
     */
    public function get($key = null, $default = null, $required = true)
    {
        if (is_null($key)) {
            return $this->getParams;
        }
        if (isset($this->getParams[$key])) {
            return $this->getParams[$key];
        } elseif (!empty($default)) {
            return $default;
        } elseif ($required) {
            throw new \LogicException("couldn't retrieve [$key] from the request $_GET data");
        }
        return null;
    }

    /**
     * @param $key string key in the $_POST array. If null then the whole array is returned
     * @param mixed $default fallback value, if nothing specified and key does not exists - throws Exception
     * @return mixed if key exist it returns data from the $_POST super global
     */
    public function post($key = null, $default = null, $required = true)
    {
        if (is_null($key)) {
            return $this->postParams;
        }
        if (isset($this->getParams[$key])) {
            return $this->postParams[$key];
        } elseif (!empty($default)) {
            return $default;
        } elseif ($required) {
            throw new \LogicException("couldn't retrieve [$key] from the request $_POST data");
        }
        return null;
    }

    /**
     * @param $key string key in the route values specified in the router. If null returns whole array
     * @param mixed $default fallback value, if nothing specified and key does not exists - throws Exception
     * @return mixed if key exist it returns data from the routed url
     */
    public function route($key = null, $default = null, $required = true)
    {
        if (is_null($key)) {
            return $this->routeParams;
        }
        if (isset($this->getParams[$key])) {
            return $this->routeParams[$key];
        } elseif (!empty($default)) {
            return $default;
        } elseif ($required) {
            throw new \LogicException("couldn't retrieve [$key] from the request url route data");
        }
        return null;
    }
}