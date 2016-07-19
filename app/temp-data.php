<?php
namespace app;
/**
 * Class TempData
 * Used to store data to be accessed only once, just like ASP.NET TempData.
 * Used primarily to show result of some sort after redirection.
 */
class TempData
{
    public static function get($offset)
    {
        $value = $_SESSION[$offset];
        unset($_SESSION[$offset]);
        return $value;
    }

    public static function set($offset, $value)
    {
        $_SESSION[$offset] = $value;
    }
}