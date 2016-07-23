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
        $this->viewBag['id'] = $rq->route('id', 420);
        $this->viewBag['author'] = $rq->route('name', 'toumash');
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

    public function status(Request $rq)
    {
        $code = $rq->route('id', 418, false);
        return $this->statusCode($code);
    }

    public function simpleContent(Request $rq)
    {
        return $this->content('simple text content generated from url query string: ' . print_r($rq->get(), true));
    }

    public function formTest(Request $rq)
    {
        if ($rq->isPost()) {
            if (!$this->validateAntiForgeryToken($rq)) {
                $this->validationErrors[] = 'AntiForgeryToken invalid';
                return $this->view();
            }
            $model = (object)[
                'name' => htmlspecialchars(trim($rq->post('name'))),
            ];
            if (strlen($model->name) < 3) {
                $this->validationErrors['name'] = 'Name must be at least 3 characters long';
            }
            if ($this->isModelValid()) {
                # return $this->redirect('example/formSuccess');
                return $this->content("hurray! Your name is {$model->name}");
            }
            $this->viewBag['name'] = $model->name;
            return $this->view();
        }
        return $this->view();
    }

    public function formSuccess()
    {
        return $this->content('hurray!');
    }


}