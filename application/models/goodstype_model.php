<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * Date: 2019-07-06
 * Time: 13:50
 */

class Goodstype_model extends CI_Model
{
    const TBL_GT = 'goods_type';

    # add new goods type
    public function add_goodstype($data){
        return $this->db->insert(self::TBL_GT, $data);
    }

    # get all the goods types
    public function get_all_types(){
        $query = $this->db->get(self::TBL_GT);
        return $query->result_array();
    }

    # Pagination data
    public function list_goodstype($limit, $offset){
        $query = $this->db->limit($limit, $offset)->get(self::TBL_GT);
        return $query->result_array();
    }

    # get the total number of rows
    public function total_rows(){
        return $this->db->count_all(self::TBL_GT);
    }

}