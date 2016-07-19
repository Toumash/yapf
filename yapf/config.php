<?php
namespace yapf;
class Config
{
    private static $instance;
    /** @var bool
     */
    private $debug = false;
    private $view_ext = '.tpl.php';

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

    public function getViewExtension()
    {
        return $this->view_ext;
    }

    public function setViewExtension($ext)
    {
        if (is_string($ext)) {
            $this->view_ext = $ext;
        }
    }

}