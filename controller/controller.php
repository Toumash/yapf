<?php

namespace controller;

use view\ViewException;

abstract class controller
{
    /**
     * @var array
     */
    protected $params;

    /**
     * @var array
     * stores model data for a view
     */
    protected $ViewBag = array();

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @param $_view_name string - view name in view/CALLING_CLASS/view_name.php
     */
    // _view_name named with leading underscore to omit overrides by extract
    public function view($_view_name)
    {
        extract($this->ViewBag, EXTR_OVERWRITE);
        require $this->getViewFilePath($_view_name);
    }

    private function getViewFilePath($view_name)
    {
        # fastest way to get callers base class name without namespaces
        $class_name = (new \ReflectionClass($this))->getShortName();
        # gets everything before _controller name
        $class_name = substr($class_name, 0, strpos($class_name, '_'));
        $file = app . DS
            . 'view' . DS
            . $class_name . DS
            . $view_name . '.php';
        if (file_exists($file)) {
            return $file;
        }

        $file = app . DS
            . 'view' . DS
            . '_shared' . DS
            . $view_name . '.php';
        if (file_exists($file)) {
            return $file;
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