<?php
/**
 * Created by PhpStorm.
 * User: hefan hefanpumch@outlook.com
 * admin_model
 * Date: 2019-07-03
 * Time: 23:04
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_admin($name, $pwd){

        $res = $this->db->select('admin_name')
                        ->from('ci_admin')
                        ->where(array('admin_name'=>$name, 'password'=>$pwd,))
                        ->get();

        $result = $res->row();
//        echo $this->db->last_query();
//        var_dump($result);
//        exit();
        return $result;
    }

}