<?php
namespace yapf;


class View
{
    /**
     * @var array
     */
    private $ViewBag = [];
    private $path;

    /** @var array */
    private $sections = [];
    /**
     * @var string
     */
    private $buffer;

    public function setData(array $viewBag)
    {
        $this->ViewBag = $viewBag;
    }

    public function renderBody()
    {
        echo $this->buffer;
    }

    public function start_section()
    {
        ob_start();
    }

    public function end_section($name)
    {
        if (!isset($this->sections[$name])) {
            $this->sections[$name] = [];
        }
        $this->sections[$name][] = ob_get_clean();
    }

    public function layout($view_name, $controller = '')
    {

        $this->setTemplate($view_name, $controller);
    }

    public function setTemplate($view_name, $controller_name = '')
    {
        $this->path = $this->getViewFilePath($view_name, $controller_name);
    }

    private function getViewFilePath($view_name, $controller_name = '')
    {
        $view_ext = Config::getInstance()->getViewExtension();
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

    public function renderSection($name)
    {
        foreach ($this->sections[$name] as $part) {
            echo $part;
        }
        unset($this->sections[$name]);
    }

    public function render()
    {
        $this->buffer = '';
        while (isset($this->path)) {
            $load = $this->path;
            $this->path = null;
            ob_start();
            require $load;
            $this->buffer = ob_get_clean();
        }
        echo $this->buffer;
    }
}