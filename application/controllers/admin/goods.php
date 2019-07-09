<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * Date: 2019-07-07
 * Time: 21:38
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Goods extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('goodstype_model');
        $this->load->model('attribute_model');
        $this->load->model('category_model');
        $this->load->model('brand_model');
        $this->load->model('goods_model');
        $this->load->library('form_validation');
    }

    # load the page of goods list
    public function index(){
        $this->load->view('goods_list.html');
    }

    # load the page for adding goods
    public function add(){

        # get info of goods types
        $data['good_types'] = $this->goodstype_model->get_all_types();

        # get info of goods categories
        $data['cates'] = $this->category_model->list_cate();

        # get info of goods brands
        $data['brands'] = $this->brand_model->list_brand();

        $this->load->view('goods_add.html', $data);
    }

    # insert goods information into database
    public function insert(){
        #set form_validation rules
        $this->form_validation->set_rules('goods_name', 'goods name', 'required');
        $this->form_validation->set_rules('shop_price', 'shop price', 'required');

        if($this->form_validation->run() == false){
            $data['message'] = validation_errors();
            $data['wait'] = 3;
            $data['url'] = site_url('admin/goods/add');
            $this->load->view('message.html', $data);
        }else{
            $data['goods_name'] = $this->input->post('goods_name', TRUE);
            $data['goods_sn'] = $this->input->post('goods_sn', TRUE);
            $data['cat_id'] = $this->input->post('cat_id', TRUE);
            $data['brand_id'] = $this->input->post('brand_id', TRUE);
            $data['shop_price'] = $this->input->post('shop_price', TRUE);
            $data['market_price'] = $this->input->post('market_price', TRUE);
            $data['promote_price'] = $this->input->post('promote_price', TRUE);
            $data['promote_start_time'] = strtotime($this->input->post('promote_start_time', TRUE));
            $data['promote_end_time'] = strtotime($this->input->post('promote_end_time', TRUE));
            $data['goods_number'] = $this->input->post('goods_number', TRUE);
            $data['is_best'] = $this->input->post('is_best', TRUE);
            $data['goods_brief'] = $this->input->post('goods_brief', TRUE);
            $data['is_new'] = $this->input->post('is_new', TRUE);
            $data['is_hot'] = $this->input->post('is_hot', TRUE);
            $data['is_onsale'] = $this->input->post('is_onsale', TRUE);

            #upload pictures
            $config['upload_path'] = './public/uploads';
            $config['allowed_types'] = 'jpg|gif|png|jpeg';
            $config['max_size'] = 1024;
            $config['file_name'] = uniqid();

            $this->load->library('upload', $config);

            if($this->upload->do_upload('goods_img')){
                #upload success, resize the picture
                $img_info = $this->upload->data();
//                var_dump($img_info);
                $data['goods_img'] = $img_info['file_name'];

                $config_img['image_library'] = 'gd2';
                $config_img['source_image'] = "./public/uploads/".$img_info['file_name'];
//                $config_img['source_image'] = $img_info['full_path'];
                $config_img['create_thumb'] = TRUE;
                $config_img['maintain_ratio'] = TRUE;
                $config_img['width'] = 160;
                $config_img['height'] = 160;

//                $this->load->library('image_lib', $config_img);

                $this->load->library('image_lib');
//                var_dump($config_img);

                $this->image_lib->initialize($config_img);

//                $this->image_lib->clear();


                if($this->image_lib->resize()){

                    $data['goods_thumb'] = $img_info['raw_name'].$this->image_lib->thumb_marker.$img_info['file_ext'];

//                    echo $data['goods_thumb'];
//                    echo $this->image_lib->display_errors();
//                    $this->output->enable_profiler(TRUE);
                    $this->image_lib->clear();

                    if($goods_id = $this->goods_model->add_goods($data)){
                        # Add goods successfully, get the info of attributes and insert the info into goods_attr table
                        $attr_ids = $this->input->post('attr_id_list');
                        $attr_values = $this->input->post('attr_value_list');
                        foreach ($attr_values as $k => $v){
                            if (!empty($v)){
                                $data2['goods_id'] = $goods_id;
                                $data2['attr_id'] = $attr_ids[$k];
                                $data2['attr_value'] = $v;

                                # insert into goods_attr table
                                $this->db->insert('goods_attr', $data2);
                            }
                        }

                        # info for successful insertion
                        $data['message'] = 'Add goods successfully';
                        $data['wait'] =3;
                        $data['url'] = site_url('admin/goods/index');

                        $this->load->view('message.html', $data);

                    }else{
                        # add goods failed
                        $data['message'] = 'Add goods failed';
                        $data['wait'] =3;
                        $data['url'] = site_url('admin/goods/add');

                        $this->load->view('message.html', $data);
                    }

                }else{
                    # resize failed
                    $data['message'] = $this->image_lib->display_errors();
                    $data['wait'] =3;
                    $data['url'] = site_url('admin/goods/add');
                    $this->image_lib->clear();

                    $this->load->view('message.html', $data);
                }

            }else{
                #upload failed
                $data['message'] = $this->upload->display_errors();
                $data['wait'] =3;
                $data['url'] = site_url('admin/goods/add');
                $this->load->view('message.html', $data);
            }

        }
    }

    # load the page for editing goods
    public function edit(){
        $this->load->view('goods_edit.html');
    }

    # Create the html for goods attributes
    public function create_attrs_html(){

        # get the type id
        $type_id = $this->input->get('type_id');
        //echo $type_id;

        # get all the attributes of the goods with the id of $type_id
        $attrs = $this->attribute_model->get_attributes($type_id);

        $html = '';

        foreach ($attrs as $attr){
            $html .= "<tr>";
            $html .= "<td class='label'>".$attr['attr_name']."</td>";
            $html .= "<td>";
            $html .= "<input type='hidden' name='attr_id_list[]' value='".$attr['attr_id']."'>";
            switch ($attr['attr_input_type']){
                case 0:
                    # text
                    $html .= "<input name='attr_value_list[]' type='text' size='40'>";
                    break;
                case 1:

                    break;
                case 2:
                    $arr = explode(PHP_EOL, $attr['attr_value']);
                    $html .= "<select name='attr_value_list[]'>";
                    $html .= "<option value=''>Please choose...</option>";
                    foreach ($arr as $v){
                        $html .= "<option value='$v'>$v</option>";
                    }
                    $html .= "</select>";
                    break;
            }

            $html .= "</td>";
            $html .= "</tr>";
        }

        echo $html;
    }

}