<?php
namespace app;
class Config
{
    private static $instance;
    /** @var bool
     */
    private $debug = false;

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

}