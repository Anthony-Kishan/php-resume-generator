<?php
# HomeController.php

class HomeController extends Controller
{
    public function index($a = '', $b = '', $c = '')
    {
        $model = new Model;
        $arr['id'] = 6;
        // $arr['name'] = "Modhu Kishan";
        // $arr['email'] = "modhukishan@yopmail.com";
        // $arr['password'] = "modhukishan@yopmail.com";
        $result = $model->where($arr);

        show($result);
        $this->view('home');
    }
}
