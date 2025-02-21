<?php
# HomeController.php

class HomeController extends Controller
{
    public function index($a = '', $b = '', $c = '')
    {
        $user = new User;
        // $id = 5;
        $arr['id'] = 6;
        // $arr['name'] = "Aorpi";
        // $arr['email'] = "aorpi@yopmail.com";
        // $arr['password'] = "aorpi@yopmail.com";

        // $result = $user->update($id, $arr);
        // $result = $user->findAll();
        $result = $user->where( $arr);
        // $result = $user->insert($arr);

        show("From the index method of HomeController");
        $this->view('home');
    }

    public function edit($a = '', $b = '', $c = '')
    {
        show("From the edit method of HomeController");
        $this->view('home');
    }
}
