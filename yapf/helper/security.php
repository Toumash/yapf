<?php

namespace yapf\helper;


class Security
{
    public static function generateAntiForgeryToken()
    {
        //Get the IP-address of the user
        $ip = $_SERVER['REMOTE_ADDR'];

        //We use mt_rand() instead of rand() because it is better for generating random numbers.
        //We use 'true' to get a longer string.
        //See http://www.php.net/mt_rand for a precise description of the function and more examples.
        $random = uniqid(mt_rand(), true);

        //Return the hash
        return md5($ip . $random);
    }

}