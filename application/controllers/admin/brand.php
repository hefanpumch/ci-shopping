<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * Brand Controller
 * Date: 2019-07-05
 * Time: 16:02
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('brand_model');
        $this->load->library('upload');
    }

    # show the page for listing all the brand
    public function index(){
        # get the brands list
        $data['brands'] = $this->brand_model->list_brand();
        $this->load->view('brand_list.html', $data);
    }

    # show the page for adding brand
    public function add(){
        $this->load->view('brand_add.html');
    }

    # show the page for editing brand
    public function edit(){
        $this->load->view('brand_edit.html');
    }

    # insert brand info into database
    public function insert(){
        # set form validation rules
        $this->form_validation->set_rules('brand_name', 'Brand name', 'required');

        if($this->form_validation->run() == false){

            # validation failed
            $data['message'] = validation_errors();
            $data['wait'] =3;
            $data['url'] = site_url('admin/brand/add');
            $this->load->view('message.html', $data);

        }else{

            # validation success
            # upload brand logo

            if($this->upload->do_upload('logo')){
                # upload successfully, get the logo picture file name
                $fileinfo = $this->upload->data();
                $data['logo'] = $fileinfo['file_name'];

                # get the form data
                $data['brand_name'] = $this->input->post('brand_name');
                $data['url'] = $this->input->post('url');
                $data['brand_desc'] = $this->input->post('brand_desc');
                $data['sort_order'] = $this->input->post('sort_order');
                $data['is_show'] = $this->input->post('is_show');

                # insert data
                if($this->brand_model->add_brand($data)){
                    $data['message'] = 'Add brand successfully';
                    $data['wait'] =3;
                    $data['url'] = site_url('admin/brand/index');
                    $this->load->view('message.html', $data);
                }else{
                    $data['message'] = 'Add brand failed';
                    $data['wait'] =3;
                    $data['url'] = site_url('admin/brand/add');
                    $this->load->view('message.html', $data);
                }

            }else{
                # upload failed
                $data['message'] = $this->upload->display_errors();
                $data['wait'] =3;
                $data['url'] = site_url('admin/brand/add');
                $this->load->view('message.html', $data);
            }
        }
    }
}