<?php
namespace yapf;
class Config
{
    private static $instance;

    private $debug = false;
    private $view_extension = '.tpl.php';
    private $default_controller = 'home';
    private $base_path = '';

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->base_path;
    }

    /**
     * @param string $base_path
     */
    public function setBasePath($base_path)
    {
        $this->base_path = $base_path;
    }

    private function __construct()
    {
    }

    /**  @return Config
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c();
        }
        return self::$instance;
    }

    /**
     * @return string
     */
    public function getDefaultController()
    {
        return $this->default_controller;
    }

    /**
     * @param string $default_controller
     */
    public function setDefaultController($default_controller = 'home')
    {
        $this->default_controller = $default_controller;
    }

    public function isRelease()
    {
        return !$this->isDebug();
    }

    public function isDebug()
    {
        return $this->debug;
    }

    public function setDebug($env = true)
    {
        if (is_bool($env)) {
            $this->debug = $env;
        }
    }

    public function setRelease($env = false)
    {
        if (is_bool($env)) {
            $this->debug = !$env;
        }
    }

    public function getViewExtension()
    {
        return $this->view_extension;
    }

    public function setViewExtension($ext)
    {
        if (is_string($ext)) {
            $this->view_extension = $ext;
        }
    }

}