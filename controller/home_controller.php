<?php
namespace controller;

class home_controller extends controller
{

    public function index()
    {
        return $this->view("index");
    }
}