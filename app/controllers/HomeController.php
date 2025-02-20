<?php
# HomeController.php

class HomeController extends Controller
{
    public function index($a = '', $b = '', $c = '')
    {
        $user = new User;
        // $id = 6;
        $arr['id'] = 5;
        // $arr['name'] = "Kishan Modhu";
        // $arr['email'] = "kishanmodhu@yopmail.com";
        // $arr['password'] = "kishanmodhu@yopmail.com";

        // $result = $model->update($id, $arr);
        // $result = $model->where( $arr);
        $result = $user->where($arr);

        show($result);
        $this->view('home');
    }
}
