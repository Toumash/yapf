<?php

class Config
{
private static $instance;

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

    /** @var bool
     */
    private $debug = false;

    public function setDebug($env = true)
    {
        if (is_bool($env)) {
            $this->debug = $env;
        }
    }

    public function isDebug()
    {
        return $this->debug;
    }

    public function isRelease()
    {
        return !$this->isDebug();
    }

}