<?php
namespace yapf;
/**
 * Class TempData
 * Used to store data to be accessed only once, just like ASP.NET TempData.
 * Used primarily to show result of some sort after redirection.
 */
class TempData
{
    public function get($offset)
    {
        if (isset($_SESSION['tmp'])) {
            $value = $_SESSION['tmp'][$offset];
            unset($_SESSION['tmp'][$offset]);
            return $value;
        }
        return null;
    }

    public function set($offset, $value)
    {
        $_SESSION['tmp'][$offset] = $value;
    }
}