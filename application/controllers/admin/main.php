<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * define the controller for admin
 * Date: 2019-07-03
 * Time: 14:40
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends Admin_Controller
{
    #Show the Admin pages
    public function index(){
        $this->load->view('index.html');
    }

    #Show the header
    public function top(){
        $this->load->view('top.html');
    }

    #Show the menu
    public function menu(){
        $this->load->view('menu.html');
    }

    #Show the drag
    public function drag(){
        $this->load->view('drag.html');
    }

    #Show the content
    public function content(){
        $this->load->view('main.html');
    }

}