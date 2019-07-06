<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * Date: 2019-07-06
 * Time: 11:40
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Goodstype extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('goodstype_model');
        $this->load->library('pagination');
    }

    public function index($offset = ''){

        # config pagination
        $config['base_url'] = site_url('admin/goodstype/index');
        $config['total_rows'] = $this->goodstype_model->total_rows();
        $config['per_page'] = 3;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);
        $data['page_info'] = $this->pagination->create_links();

        $limit = $config['per_page'];

        $data['goodstypes'] = $this->goodstype_model->list_goodstype($limit, $offset);
        $this->load->view('goods_type_list.html', $data);
    }

    public function add(){
        $this->load->view('goods_type_add.html');
    }

    public function edit(){
        $this->load->view('goods_type_edit.html');
    }

    # insert goods type information into database
    public function insert(){

        # set form validation rules
        $this->form_validation->set_rules('type_name', 'Goods type name', 'required');

        if($this->form_validation->run() == false){

            # form validation failed
            $data['message'] = validation_errors();
            $data['wait'] = 3;
            $data['url'] = site_url('admin/goodstype/add');
            $this->load->view('message.html', $data);
        }else{

            #form validation successfully
            $data['type_name'] = $this->input->post('type_name', true);

            if($this->goodstype_model->add_goodstype($data)){
                $data['message'] = 'Add goods type successfully';
                $data['wait'] = 3;
                $data['url'] = site_url('admin/goodstype/index');
                $this->load->view('message.html', $data);
            }else{
                $data['message'] = 'Add goods type failed';
                $data['wait'] = 3;
                $data['url'] = site_url('admin/goodstype/add');
                $this->load->view('message.html', $data);
            }
        }

    }

}