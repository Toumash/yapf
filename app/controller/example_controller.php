<?php

namespace app\controller;


class example_controller extends \yapf\controller
{
    public function index()
    {
        return $this->view();
    }

    public function selfCheck(array $data)
    {
        $this->ViewBag['id'] = isset($data['id']) ? $data['id'] : 420;
        $this->ViewBag['author'] = isset($data['name']) ? $data['name'] : 'toumash';
        return $this->view('selfCheck');
    }

    public function jsonTest(array $data)
    {
        return $this->json($data);
    }

    public function xmlTest()
    {
        $data = [
            'author' => 'toumash',
            'date' => date('d-m-y')
        ];
        return $this->xml('data', $data);
    }

    public function status()
    {
        return $this->statusCode(418);
    }
}