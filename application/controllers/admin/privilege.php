<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * Define the controller for authorization check
 * Date: 2019-07-03
 * Time: 16:27
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class privilege extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('captcha');
        $this->load->library('form_validation');
    }

    public function login(){

        # Create captcha
//        $vals = array(
//            'word' => rand(1000,9999),
//            'img_path' => './data/captcha/',
//            'img_url' => base_url('data/captcha/'),
//        );
//
//        $data = create_captcha($vals);

        # load the login page
        $this->load->view('login.html');
    }

    # Create captcha
    public function code(){

        $vals = array(
            'word_length' => 6
        );
        $code = create_captcha($vals);

        # store the word of captcha into session
        $this->session->set_userdata('code', $code);
    }

    # validate login
    public function signin(){
        # set the rules for form validation
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        #get the form data
        $captcha = strtolower($this->input->post('captcha'));

        #get the code from session
        $code = strtolower($this->session->userdata('code'));

        #check whether the verification code matches the code in session
        if($captcha === $code){
            # captcha validation is successful, then validate the username and password

            if($this->form_validation->run() == false){
                $data['message'] = validation_errors();
                $data['url'] = site_url('admin/privilege/login');
                $data['wait'] = 3;

                $this->load->view('message.html', $data);

            }else{
                $username = $this->input->post('username', TRUE);
                $password = $this->input->post('password', TRUE);

                if($username == 'admin' and $password == '123'){
                    # username and password validation is successful
                    # store the data into session
                    # redirect to the main page
                    $this->session->set_userdata('admin', $username);
                    redirect('admin/main/index');

                }else{
                    # username and password validation is unsuccessful
                    $data['url'] =site_url('admin/privilege/login');
                    $data['message'] = 'Wrong username or wrong password, please try again';
                    $data['wait'] = 3;

                    $this->load->view('message.html', $data);

                }
            }

        }else{
            # captcha validation failed, show the notification page, redirect to the login page
            $data['url'] =site_url('admin/privilege/login');
            $data['message'] = 'Wrong verification code, please try again';
            $data['wait'] = 3;

            $this->load->view('message.html', $data);

        }

    }

    public function logout(){
        $this->session->unset_userdata('admin');
        $this->session->sess_destroy();
        redirect('admin/privilege/login');
    }

}