<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * Date: 2019-07-10
 * Time: 02:07
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class goods_model extends CI_Model
{
    const TBL_GOODS = 'goods';

    # add goods, return the id of newly inserted record
    public function add_goods($data){
        $query = $this->db->insert(self::TBL_GOODS, $data);
        return $query ? $this->db->insert_id() : FALSE;
    }

}