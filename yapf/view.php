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
        $this->path = $this->resolvePath($view_name, $controller_name);
    }

    private function resolvePath($view_name, $controller_name = '')
    {
        $extension = Config::getInstance()->getViewExtension();

        $search_path = [];
        # this one with controller name MUST be first
        # 1. direct controller/method.ext
        if (!empty($controller_name))
            $search_path[] = app_view . $controller_name . DS . $view_name . $extension;
        # 2. directly view/$view_name.exe
        $search_path[] = app_view . str_replace('/', DIRECTORY_SEPARATOR, ltrim($view_name, '/')) . $extension;
        # 3. _shared/method.ext
        $search_path[] = app_view . '_shared' . DS . $view_name . $extension;

        foreach ($search_path as $view_filename) {
            if (file_exists($view_filename)) {
                return $view_filename;
            }
        }
        throw new ViewResolverException("No view found for [$controller_name] view: [$view_name]. searched locations:"
            . implode(';', $search_path));
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