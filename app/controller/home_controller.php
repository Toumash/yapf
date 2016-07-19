<?php
namespace app\controller;

class home_controller extends \yapf\controller
{
    public function index()
    {
        return $this->view();
    }

    public function self_check($id = '123', $name = 'toumash')
    {
        $this->ViewBag['id'] = $id;
        $this->ViewBag['author'] = $name;
        return $this->view();
    }
}