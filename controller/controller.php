<?php

namespace controller;

use view\ViewException;

abstract class controller
{
    protected $params;

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @param $view_name string - view name in view/CALLING_CLASS/view_name.php
     */
    public function view($view_name)
    {
        # fastest way to get callers base class name without namespaces
        $class_name = (new \ReflectionClass($this))->getShortName();
        # gets everything before _controller name
        $class_name = substr($class_name, 0, strpos($class_name, '_'));
        $file = app . DIRECTORY_SEPARATOR
            . 'view' . DIRECTORY_SEPARATOR
            . $class_name . DIRECTORY_SEPARATOR
            . $view_name . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }

        $file = app . DIRECTORY_SEPARATOR
            . 'view' . DIRECTORY_SEPARATOR
            . '_shared' . DIRECTORY_SEPARATOR
            . $view_name . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
        throw new ViewException("No view found for " . $class_name . ' view:' . $view_name);
    }

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    public function isDelete()
    {
        return $_SERVER['REQUEST_METHOD'] == 'DELETE';
    }
}