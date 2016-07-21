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
    /**
     * @param string|null $view_name
     * @return View
     */
    public function view($view_name = null)
    {
        if (!isset($view_name)) {
            $view_name = $this->getCaller(2);
        }
        $view = new View();
        $view->setTemplate($view_name, $this->getControllerName());
        $view->setData($this->ViewBag);

        $view->render();
    }

    /**
     * @param $depth integer depth = 1 -> calling function of getCaller. One more caller of caller of getCaller ;)
     * @return string
     */
    protected function getCaller($depth = 1)
    {
        $dbt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3); // FIXME
        $caller = isset($dbt[$depth]['function']) ? $dbt[$depth]['function'] : null;
        return $caller;
    }

    public function getControllerName()
    {
        # fastest way to get callers base class name without namespaces
        $class_name = (new \ReflectionClass($this))->getShortName();
        # gets everything before _controller name
        $controller_name = substr($class_name, 0, strpos($class_name, '_'));
        return $controller_name;
    }

    public function json(array $data, $options = 0, $depth = 512)
    {
        echo json_encode($data, $options, $depth);
    }

    public function statusCode($code = 200)
    {
        return http_response_code($code);
    }

    public function xml($root_name, array $data)
    {
        $xml = $this->to_xml($root_name, $data);
        if ($xml === false) {
            throw new ViewRendererException("Cannot create xml message");
        }
        echo $xml;
    }

    private function to_xml($root_name, array $data)
    {
        $object = new \SimpleXMLElement("<$root_name/>");
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $new_object = $object->addChild($key);
                $this->to_xml($new_object, $value);
            } else {
                $object->addChild($key, $value);
            }
        }
        return $object->asXML();
    }

    public function content($content_string)
    {
        echo $content_string;
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