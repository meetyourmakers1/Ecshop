<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Loader extends CI_Loader{

    protected $_themes = 'admin\\';

    //开启主题
    public function switch_themes_on(){
        $this->_ci_view_paths = array(FCPATH . THEMES_DIR . $this->_themes	=> TRUE);
    }

    //关闭主题
    public function switch_themes_off(){

    }
}