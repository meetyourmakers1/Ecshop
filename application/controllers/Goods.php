<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goods extends Home_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('Goods_model');
    }

    public function index($goods_id){
        $data['good'] = $this->Goods_model->goods_one($goods_id);
        $this->load->view('goods.html',$data);
    }
}