<?php
namespace app\controller;
use yapf\Request;

class home_controller extends \yapf\controller
{
    public function index(Request $rq)
    {
        return $this->view();
    }
}