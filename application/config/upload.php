<?php
/**
 * Created by PhpStorm.
 * User: hefan
 * Date: 2019-07-05
 * Time: 23:58
 */

defined('BASEPATH') OR exit('No direct script access allowed');

$config['upload_path'] = './public/uploads/';
$config['allowed_types'] = 'gif|png|jpg|jpeg';
$config['max_size'] = 100;
$config['file_name'] = uniqid();

