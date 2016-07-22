<?php
namespace yapf;


use yapf\helper\Security;

class View
{
    /**
     * @var array
     */
    private $viewBag = [];
    private $validationErrors = [];
    private $path;

    /** @var array */
    private $sections = [];
    /**
     * @var string
     */
    private $buffer;

    public function setData(array $viewBag)
    {
        $this->viewBag = $viewBag;
    }

    public function renderBody()
    {
        echo $this->buffer;
    }

    public function startSection()
    {
        ob_start();
    }

    public function endSection($name)
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
        if (empty($view_name)) {
            $this->path = '';
        } else {
            $this->path = $this->resolvePath($view_name, $controller_name);
        }
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
        throw new ViewRendererException("No view found for [$controller_name] view: [$view_name]. searched locations:"
            . implode(';', $search_path));
    }

    public function antiForgeryToken()
    {
        $token = Security::generateAntiForgeryToken();
        $_SESSION['form_key'] = $token;
        echo "<input type='hidden' name='form_key' value='$token'/>";
    }

    public function renderSection($name, $required = false)
    {
        if (isset($this->sections[$name])) {
            foreach ($this->sections[$name] as $part) {
                echo $part;
            }
            unset($this->sections[$name]);
        } else if ($required) {
            throw new ViewRendererException("Couldn't find required section $name");
        }
    }

    public function render()
    {
        $this->buffer = '';
        while (!empty($this->path)) {
            $load = $this->path;
            $this->path = '';
            ob_start();
            require $load;
            $this->buffer = ob_get_clean();
        }
        echo $this->buffer;
    }

    public function setErrors(array $errors)
    {
        $this->validationErrors = $errors;
    }

    protected function labelFor($name, $text, array $attrib = [])
    {
        $attrib['for'] = $name;
        $this->createHtmlElement('label', $text, $attrib);
    }

    private function createHtmlElement($name, $value, array $attrib = [])
    {
        //TODO: THIS FUNCTION NEEDS SERIOUS TESTING
        echo "<$name ";
        foreach ($attrib as $key => $val) {
            echo "$key=\"{$val}\"";
        }
        echo ">$value</$name>";
    }

    protected function editorFor($name, $value, $attrib = [])
    {
        $attrib['type'] = 'text';
        $attrib['name'] = $name;
        $attrib['value'] = $value;
        $this->createHtmlElement('input', '', $attrib);
    }

    protected function validationMessageFor($name, $message = '', $attrib = [])
    {
        if (isset($this->validationErrors[$name])) {
            $message = empty($message) ? $this->validationErrors[$name] : $message;
            $this->createHtmlElement('span', $message, $attrib);
        }
    }

    protected function validationSummary($message = '', array $attrib = [])
    {
        # message
        if (!empty($message)) {
            $this->createHtmlElement('span', $message, $attrib);
        }

        # rest of the errors
        foreach ($this->validationErrors as $error) {
            $this->createHtmlElement('span', $error, $attrib);
        }
    }
}