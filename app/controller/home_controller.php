<?php
namespace app\controller;

class home_controller extends \yapf\controller
{
    public function index()
    {
        return $this->view();
    }

    public function self_check(array $data)
    {
        $this->ViewBag['id'] = $data['id'];
        $this->ViewBag['author'] = $data['name'];
        return $this->view('home\self_check');
    }

    public function jsonTest(array $data)
    {
        return $this->json($data);
    }
}