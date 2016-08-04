<?php

namespace yapf;


abstract class controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $validationErrors = [];
    /**
     * @var array
     * stores model data for a view
     */
    protected $viewBag = [];

    public function setRequestData(Request $rq)
    {
        $this->request = $rq;
    }

    /**
     * @param $_view_name string - view name in view/CALLING_CLASS/view_name.php
     */
    // _view_name named with leading underscore to omit overrides by extract
    /**
     * @param string|null $view_name
     * @return View
     */
    protected function view($view_name = null, $model = null)
    {
        if (!isset($view_name)) {
            $view_name = $this->getCaller(2);
        }
        $view = new View();
        $view->setTemplate($view_name, $this->getControllerName());
        $view->setData($this->viewBag);
        $view->setErrors($this->validationErrors);

        $view->render();
    }

    /**
     * @param $depth integer depth = 1 -> calling function of getCaller. One more caller of caller of getCaller ;)
     * @return string
     */
    protected function getCaller($depth = 1)
    {
        $dbt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $depth + 1);
        $caller = isset($dbt[$depth]['function']) ? $dbt[$depth]['function'] : null;
        return $caller;
    }

    public function getControllerName()
    {
        $name = $this->request->getController();
        if (!empty($name)) {
            return $name;
        }

        # fastest way to get callers base class name without namespaces
        $class_name = (new \ReflectionClass($this))->getShortName();
        # gets everything before _controller name
        $controller_name = substr($class_name, 0, strpos($class_name, '_'));
        return $controller_name;
    }

    protected function json(array $data, $httpCode = 200, $options = 0, $depth = 512)
    {
        header('Content-Type: application/json', true, $httpCode);
        echo json_encode($data, $options, $depth);
        return true;
    }

    protected function statusCode($code = 200)
    {
        return http_response_code($code);
    }

    protected function xml($root_name, array $data, $httpCode = 200)
    {
        $xml = $this->to_xml($root_name, $data);
        if ($xml === false) {
            throw new ViewRendererException("Couldn't create xml message");
        }
        header('Content-Type: application/xml', true, $httpCode);
        echo $xml;
        return true;
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

    protected function isModelValid()
    {
        return empty($this->validationErrors);
    }

    /**
     * @param $content_string string which will be directly written to response
     */
    protected function content($content_string)
    {
        echo $content_string;
        return true;
    }

    /**
     * @param $where 'just like a element href="$where". Always absolute
     */
    protected function redirect($location, $remote = false)
    {
        // TODO: get www basePath from Configuration just like the AltoRouter
        if ($remote) {
            header("Location: $location", true, 302);
        } else {
            $host = $_SERVER['HTTP_HOST'];
            $location = ltrim($location, '/');
            $base = Config::getInstance()->getBasePath();
            $base = empty($base)?'':$base.'/';
            header("Location: http://$host/$base$location", true, 302);
        }
        return true;
    }

    protected function validateAntiForgeryToken(Request $rq)
    {
        return $_SESSION['form_key'] == $rq->post('form_key', '', false);
    }
}