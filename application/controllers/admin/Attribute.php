<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attribute extends Admin_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('Type_model');
        $this->load->model('Attribute_model');
    }

    public function index(){
        $data['attrs'] = $this->Attribute_model->attr_list();
        $this->load->view('attribute_list.html',$data);
    }

    public function add(){
        $data['types'] = $this->Type_model->get_types();
        $this->load->view('attribute_add.html',$data);
    }

    public function edit(){
        $this->load->view('attribute_edit.html');
    }

    public function addhandle(){
        $data['attr_name'] = $this->input->post('attr_name');
        $data['type_id'] = $this->input->post('type_id');
        $data['attr_select_type'] = $this->input->post('attr_select_type');
        $data['attr_input_type'] = $this->input->post('attr_input_type');
        $data['attr_value'] = $this->input->post('attr_values');
        $data['sort'] = $this->input->post('sort_order');
        if($this->Attribute_model->attr_add($data)){
            $data['wait_time'] = 5;
            $data['url'] = site_url('admin/attribute/index');
            $data['message'] = '添加商品类型属性成功!';
            $this->load->view('message.html',$data);
        }else{
            $data['wait_time'] = 5;
            $data['url'] = site_url('admin/attribute/add');
            $data['message'] = '添加商品类型属性失败!';
            $this->load->view('message.html',$data);
        }
    }
}