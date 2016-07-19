<?php

namespace yapf;


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
    protected $ViewBag = [];

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @param $_view_name string - view name in view/CALLING_CLASS/view_name.php
     */
    // _view_name named with leading underscore to omit overrides by extract
    public function view($_view_name = null)
    {
        if (!isset($_view_name)) {
            $_view_name = $this->getCaller(2);
        }
        extract($this->ViewBag, EXTR_OVERWRITE);
        require $this->getViewFilePath($_view_name);
        return true;
    }

    /**
     * @param $depth integer depth = 1 -> calling function of getCaller. One more caller of caller of getCaller ;)
     * @return string
     */
    protected function getCaller($depth = 1)
    {
        $dbt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        $caller = isset($dbt[$depth]['function']) ? $dbt[$depth]['function'] : null;
        return $caller;
    }

    private function getViewFilePath($view_name)
    {
        $view_ext = Config::getInstance()->getViewExtension();
        $controller_name = $this->getControllerName();
        $file = app_view . $controller_name . DS
            . $view_name . $view_ext;
        if (file_exists($file)) {
            return $file;
        }

        $file = app_view . '_shared' . DS
            . $view_name . $view_ext;
        if (file_exists($file)) {
            return $file;
        }
        throw new ViewException("No view found for " . $controller_name . ' view:' . $view_name);
    }

    public function getControllerName()
    {
        # fastest way to get callers base class name without namespaces
        $class_name = (new \ReflectionClass($this))->getShortName();
        # gets everything before _controller name
        $controller_name = substr($class_name, 0, strpos($class_name, '_'));
        return $controller_name;
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