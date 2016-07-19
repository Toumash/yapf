<?php
namespace app\controller;

class home_controller extends \yapf\controller
{
    public function index()
    {
        return $this->view();
    }
}