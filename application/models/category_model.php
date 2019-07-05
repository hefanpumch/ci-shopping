<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * Date: 2019-07-04
 * Time: 16:08
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model
{
    const TBL_CATE = 'category';

    /*
     * @access public
     * @param $pid the category id
     * @return array all the child id of this category id
     */
    public function list_cate($pid = 0){
        $query = $this->db->get(self::TBL_CATE);
        $cates = $query->result_array();

        return $this->_tree($cates, $pid);

    }

    /*
     * @access private
     * @param $arr array
     * @param $pid the category id, default 0
     * @param $level int category level, default 0
     * @return array ordered all children category id
     */
    private function _tree($arr, $pid = 0, $level =0){

        static $tree = array();

        foreach ($arr as $v){

            if($v['parent_id'] == $pid){
                $v['level'] = $level;
                $tree[] = $v;
                $this->_tree($arr, $v['cat_id'], $level+1);
            }

        }

        return $tree;

    }

    /*
     * @access public
     * @param $data the categorical information
     * @return Bool
     */
    public function add_category($data){
        return $this->db->insert(self::TBL_CATE, $data);
    }

    /*
     * Get a single category
     */
    public function get_single_cate($cat_id){
        $condition['cat_id'] = $cat_id;
        $query = $this->db->where($condition)->get(self::TBL_CATE);

        return $query->row_array();
    }

    /*
     * Update
     */
    public function update_cate($data, $cat_id){

        $condition['cat_id'] = $cat_id;
        return $this->db->where($condition)->update(self::TBL_CATE, $data);
    }


}