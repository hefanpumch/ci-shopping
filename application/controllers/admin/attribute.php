<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * Date: 2019-07-06
 * Time: 16:29
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Attribute extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('goodstype_model');
        $this->load->library('form_validation');
        $this->load->model('attribute_model');
        $this->load->library('pagination');
    }

    public function index($offset= ''){

        # config pagination
        $config['base_url'] = site_url('admin/attribute/index');
        $config['total_rows'] = $this->attribute_model->total_rows();
        $config['per_page'] = 3;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);
        $data['page_info'] = $this->pagination->create_links();

        $limit = $config['per_page'];

        $data['attrs'] = $this->attribute_model->list_attrs_type($limit, $offset);

        # display according to goods type groups
        $data['goods_types'] = $this->goodstype_model->get_all_types();

        $this->load->view('attribute_list.html', $data);
    }

    public function add(){
        # get the data of goods types
        $data['goodstypes'] = $this->goodstype_model->get_all_types();
        $this->load->view('attribute_add.html', $data);
    }

    public function edit(){
        $this->load->view('attribute_edit.html');
    }

    # add attribute
    public function insert(){
        $this->form_validation->set_rules('attr_name', 'attribute name', 'required');
        $this->form_validation->set_rules('type_id', 'Goods type', 'required');

        if($this->form_validation->run() == false){
            # validation failed
            $data['message'] = validation_errors();
            $data['wait'] =3;
            $data['url'] = site_url('admin/attribute/add');
            $this->load->view('message.html', $data);
        }else{

            $data['attr_name'] = $this->input->post('attr_name');
            $data['type_id'] = $this->input->post('type_id');
            $data['attr_type'] = $this->input->post('attr_type');
            $data['attr_input_type'] = $this->input->post('attr_input_type');
            $data['attr_value'] = $this->input->post('attr_value');
            $data['sort_order'] = $this->input->post('sort_order');

            if($this->attribute_model->add_attrs($data)){
                $data['message'] = 'Add attribute successfully';
                $data['wait'] =3;
                $data['url'] = site_url('admin/attribute/index');
                $this->load->view('message.html', $data);
            }else{
                $data['message'] = validation_errors();
                $data['wait'] =3;
                $data['url'] = site_url('admin/attribute/add');
                $this->load->view('message.html', $data);
            }

        }
    }

}




