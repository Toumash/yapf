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

    public function formTest(Request $rq)
    {
        if ($rq->isPost()) {
            if (!$this->validateAntiForgeryToken($rq)) {
                $this->ViewBag['form_errors'] = ['AntiForgeryToken invalid'];
                return $this->view();
            }
            if (strlen(trim($rq->post('name'))) < 3) {
                $this->ViewBag['form_errors']['name'] = 'Name must be at least 3 characters long';
            }
            if ($this->isModelValid()) {
                return $this->redirect('example/formSuccess');
            }
            return $this->view();
        }
        return $this->view();
    }

    public function formSuccess()
    {
        return $this->content('hurray!');
    }
}