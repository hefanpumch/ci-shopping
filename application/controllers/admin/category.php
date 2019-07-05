<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * controller for Goods' Categories
 * Date: 2019-07-04
 * Time: 14:13
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
        $this->load->library('form_validation');

        # Debug
        $this->output->enable_profiler(TRUE);
    }

    //show the categories
    public function index(){
        $data['cates'] = $this->category_model->list_cate();
        $this->load->view('cat_list.html', $data);
    }

    // show the page for adding categories
    public function add(){
        $data['cates'] = $this->category_model->list_cate();
        $this->load->view('cat_add.html', $data);
    }

    // show the page for editing categories
    public function edit($cat_id){

        $data['cates'] = $this->category_model->list_cate();
        $data['current_cat'] = $this->category_model->get_single_cate($cat_id);
        $this->load->view('cat_edit.html' ,$data);

    }

    // insert new category into database
    public function insert(){
        // Set form validation rules
        $this->form_validation->set_rules('cat_name','Categorical Name','trim|required');

        if($this->form_validation->run() == false){
            # validation failed
            $data['message'] = validation_errors();
            $data['wait'] = 3;
            $data['url'] = site_url('admin/category/add');
            $this->load->view('message.html', $data);

        }else{
            # validation success
            $data['cat_name'] = $this->input->post('cat_name', TRUE);
            $data['parent_id'] = $this->input->post('parent_id');
            $data['unit'] = $this->input->post('measure_unit', TRUE);
            $data['sort_order'] = $this->input->post('sort_order', TRUE);
            $data['is_show'] = $this->input->post('is_show');
//            $data['show_in_nav'] = $this->input->post('show_in_nav');
            $data['cat_desc'] = $this->input->post('cat_desc', TRUE);

            // use functions in model to insert the data
            if($this->category_model->add_category($data)){
                // insert success
                $data['message'] = 'Insert the categorical information successfully';
                $data['wait'] = 2;
                $data['url'] = site_url('admin/category/index');
                $this->load->view('message.html', $data);
            }else{
                // insert failed
                $data['message'] = 'Fail to add the categorical information';
                $data['wait'] = 2;
                $data['url'] = site_url('admin/category/add');
                $this->load->view('message.html', $data);
            }

        }
    }

}