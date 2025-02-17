<?php
# HomeController.php

class HomeController extends Controller
{
    public function index($a = '', $b = '', $c = '')
    {
        $model = new Model;
        $arr['id'] = 3;
        $arr['name'] = "Kishan";
        $result = $model->where($arr);

        show($result);
        $this->view('home');
    }
}
