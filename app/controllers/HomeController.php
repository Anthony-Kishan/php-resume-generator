<?php
# HomeController.php

class HomeController extends Controller
{
    public function index($a = '', $b = '', $c = '')
    {
        $model = new Model;
        $arr['id'] = 5;
        $arr['name'] = "Anthony";
        $arr['email'] = "anthony@yopmail.com";
        $arr['password'] = "anthony@yopmail.com";
        $result = $model->insert($arr);

        show($result);
        $this->view('home');
    }
}
