<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * Date: 2019-07-07
 * Time: 13:29
 */

class Attribute_model extends CI_Model
{
    const TBL_ATTR = 'attribute';

    public function add_attrs($data){
        return $this->db->insert(self::TBL_ATTR, $data);
    }

    public function list_attrs(){
        $query = $this->db->get(self::TBL_ATTR);
        return $query->result_array();
    }

    public function total_rows(){
        return $this->db->count_all(self::TBL_ATTR);
    }

    # Pagination data
    public function list_attrs_type($limit, $offset){
        $query = $this->db->limit($limit, $offset)->get(self::TBL_ATTR);
        return $query->result_array();
    }

    # get all the attributes of the goods with the specific type id

    public function get_attributes($type_id){
        $condition['type_id'] = $type_id;
        $query = $this->db->where($condition)->get(self::TBL_ATTR);
        return $query->result_array();
    }


}