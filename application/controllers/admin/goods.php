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