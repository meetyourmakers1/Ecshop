<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type extends Admin_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Type_model');
        $this->load->library('pagination');
    }

    public function index($offset = ''){
        $config['base_url'] = site_url('admin/type/index');
        $config['total_rows'] = $this->Type_model->type_count();
        $config['per_page'] = 1;
        $config['uri_segment'] = 4;
        $config['first_link'] = '首页';
        $config['last_link'] = '尾页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();
        $limit = $config['per_page'];
        $data['types'] = $this->Type_model->type_list($limit,$offset);
        $this->load->view('goods_type_list.html',$data);
    }

    public function add(){
        $this->load->view('goods_type_add.html');
    }

    public function edit(){
        $this->load->view('goods_type_edit.html');
    }

    public function addhandle(){
        $this->form_validation->set_rules('type_name','商品类型名称','required');
        if($this->form_validation->run() == false){
            $data['wait_time'] = 5;
            $data['url'] = site_url('admin/type/add');
            $data['message'] = validation_errors();
            $this->load->view('message.html',$data);
        }else{
            $data['type_name'] = $this->input->post('type_name');
            if($this->Type_model->type_add($data)){
                $data['wait_time'] = 5;
                $data['url'] = site_url('admin/type/index');
                $data['message'] = '添加商品类型成功!';
                $this->load->view('message.html',$data);
            }else{
                $data['wait_time'] = 5;
                $data['url'] = site_url('admin/type/add');
                $data['message'] = '添加商品类型失败!';
                $this->load->view('message.html',$data);
            }
        }
    }
}