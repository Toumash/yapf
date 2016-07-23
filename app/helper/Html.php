<?php

namespace app\helper;


use yapf\View;

class Html
{
    /**
     * @param array $data
     */
    public static function exampleLink($href = 'http://google.com')
    {
        View::createHtmlElement('a', 'click here', ['href' => $href]);
    }
}