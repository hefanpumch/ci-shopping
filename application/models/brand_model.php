<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * Date: 2019-07-05
 * Time: 23:00
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class brand_model extends CI_Model
{
    const TBL_BRAND = 'brand';

    # add brand
    public function add_brand($data){
        return $this->db->insert(self::TBL_BRAND, $data);
    }

    # list out all the brands
    public function list_brand(){
        $query = $this->db->get(self::TBL_BRAND);
        return $query->result_array();
    }

}