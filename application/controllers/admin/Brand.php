<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends Admin_controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Brand_model');
        $this->load->library('upload');
    }

    public function index(){
        $data['brands'] = $this->Brand_model->brand_list();
        $this->load->view('brand_list.html',$data);
    }

    public function add(){
        $this->load->view('brand_add.html');
    }

    public function edit(){
        $this->load->view('brand_edit.html');
    }

    public function addhandle(){
        $this->form_validation->set_rules('brand_name','品牌名称','required');
        if($this->form_validation->run() == false){
            $data['wait_time'] = 5;
            $data['url'] = site_url('admin/brand/add');
            $data['message'] = validation_errors();
            $this->load->view('message.html',$data);
        }else{
            if($this->upload->do_upload('brand_logo')){
                $fileinfo = $this->upload->data();
                $data['logo'] = $fileinfo['file_name'];
                $data['brand_name'] = $this->input->post('brand_name');
                $data['url'] = $this->input->post('site_url');
                $data['brand_desc'] = $this->input->post('brand_desc');
                $data['sort'] = $this->input->post('sort_order');
                $data['is_show'] = $this->input->post('is_show');
                if($this->Brand_model->brand_add($data)){
                    $data['wait_time'] = 5;
                    $data['url'] = site_url('admin/brand/index');
                    $data['message'] = '添加商品品牌成功!';
                    $this->load->view('message.html',$data);
                }else{
                    $data['wait_time'] = 5;
                    $data['url'] = site_url('admin/brand/add');
                    $data['message'] = '添加商品品牌失败!';
                    $this->load->view('message.html',$data);
                }
            }else {
                $data['wait_time'] = 5;
                $data['url'] = site_url('admin/brand/add');
                $data['message'] = $this->upload->display_errors();
                $this->load->view('message.html',$data);
            }
        }
    }
}