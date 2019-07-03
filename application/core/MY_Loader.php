<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * Date: 2019-07-03
 * Time: 01:46
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{

    protected $_theme = 'default/';
    /*
     * switch on the function for turning the website themes
     */
    public function switch_themes_on(){
        $this->_ci_view_paths = array(THEMES_DIR.$this->_theme => TRUE);
    }

    /*
     * switch off the function for turning the website themes
     */
    public function switch_themes_off(){
        # just do nothing
    }
}