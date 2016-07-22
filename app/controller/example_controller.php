<?php

namespace app\controller;

use yapf\Request;

class example_controller extends \yapf\controller
{
    public function index()
    {
        return $this->view();
    }

    public function selfCheck(Request $rq)
    {
        # gets data from the routed url, 2nd param is the default value
        $this->ViewBag['id'] = $rq->route('id', 420);
        $this->ViewBag['author'] = $rq->route('name', 'toumash');
        # optional view name
        return $this->view('selfCheck');
    }

    public function jsonTest(Request $rq)
    {
        # when no arguments specified, route returns whole array of params (assoc)
        return $this->json($rq->route());
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

    public function simpleContent(Request $rq)
    {
        return $this->content('simple text content generated from url query string: ' . print_r($rq->get(), true));
    }
}