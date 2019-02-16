<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Home_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->model('Goods_model');
    }

    public function index(){
        $data['cats'] = $this->Category_model->cat_front();
        $data['best_goods'] = $this->Goods_model->goods_best();
        $this->load->view('index.html',$data);
    }
}