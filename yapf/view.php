<?php
namespace yapf;


use yapf\helper\Security;

class View
{
    /**
     * @var array
     */
    private $viewBag = [];
    /**
     * @var array
     */
    private $validationErrors = [];
    /**
     * @var string
     */
    private $templatePath;

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

    private function layout($view_name, $controller = '')
    {
        $this->setTemplate($view_name, $controller);
    }

    public function setTemplate($view_name, $controller_name = '')
    {
        if (empty($view_name)) {
            $this->templatePath = '';
        } else {
            $this->templatePath = $this->resolvePath($view_name, $controller_name);
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

    public function render()
    {
        $this->buffer = '';
        while (!empty($this->templatePath)) {
            $load = $this->templatePath;
            $this->templatePath = '';
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

    protected function renderBody()
    {
        echo $this->buffer;
    }

    protected function startSection()
    {
        ob_start();
    }

    protected function endSection($name)
    {
        if (!isset($this->sections[$name])) {
            $this->sections[$name] = [];
        }
        $this->sections[$name][] = ob_get_clean();
    }

    protected function antiForgeryToken()
    {
        $token = Security::generateAntiForgeryToken();
        $_SESSION['form_key'] = $token;
        echo "<input type='hidden' name='form_key' value='$token'/>";
    }

    protected function renderSection($name, $required = false)
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

    /**
     * Renders label for html element
     * @param string $name name of the model element
     * @param string $text the label for the element
     * @param array $attrib html attributes for label
     */
    protected function labelFor($name, $text, array $attrib = [])
    {
        $attrib['for'] = $name;
        static::createHtmlElement('label', $text, $attrib);
    }

    public static function createHtmlElement($name, $value, array $attrib = [])
    {
        echo "<$name ";
        foreach ($attrib as $key => $val) {
            echo "$key=\"{$val}\"";
        }
        echo ">$value</$name>";
    }

    /**
     * Renders text editor for $name model-name with value of $value
     * @param string $name
     * @param string $value
     * @param array $attrib html attributes for input
     */
    protected function editorFor($name, $value, $attrib = [])
    {
        $attrib['type'] = 'text';
        $attrib['name'] = $name;
        $attrib['value'] = $value;
        static::createHtmlElement('input', '', $attrib);
    }

    /**
     * Displays validation message for a field named $name
     * @param string $name
     * @param string $message if you specify message, its gonna replace that one from controller
     * @param array $attrib
     */
    protected function validationMessageFor($name, $message = '', $attrib = [])
    {
        if (isset($this->validationErrors[$name])) {
            $message = empty($message) ? $this->validationErrors[$name] : $message;
            static::createHtmlElement('span', $message, $attrib);
        }
    }

    /**
     * Lists all errors in validationErrors
     * @param string $message additional message
     * @param array $attrib html attributes for message
     */
    protected function validationSummary($message = '', array $attrib = [])
    {
        # message
        if (!empty($message)) {
            static::createHtmlElement('span', $message, $attrib);
        }

        # rest of the errors
        foreach ($this->validationErrors as $error) {
            static::createHtmlElement('span', $error, $attrib);
        }
    }
}