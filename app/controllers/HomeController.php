<?php
# HomeController.php

class HomeController extends Controller
{
    public function index($a = '', $b = '', $c = '')
    {
        $model = new Model;
        $id = 6;
        // $arr['id'] = 6;
        // $arr['name'] = "Kishan Modhu";
        // $arr['email'] = "kishanmodhu@yopmail.com";
        // $arr['password'] = "kishanmodhu@yopmail.com";

        // $result = $model->update($id, $arr);
        // $result = $model->where( $arr);
        $result = $model->delete($id);

        show($result);
        $this->view('home');
    }
}
