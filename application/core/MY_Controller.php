<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * Date: 2019-07-03
 * Time: 02:08
 */
defined('BASEPATH') OR exit('No direct script access allowed');

//Define the home controller
class Home_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        # switch on the themes function
        $this->load->swith_themes_on();
    }

}

//Define the Admin controller
class Admin_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        # switch off the themes function
        $this->load->swith_themes_off();
    }

}