<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends Admin_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->library('form_validation');
        //$this->output->enable_profiler(TRUE);
    }

    public function index(){
        $data['cats'] = $this->Category_model->cat_list();
        $this->load->view('cat_list.html',$data);
    }

    public function add(){
        $data['cats'] = $this->Category_model->cat_list();
        $this->load->view('cat_add.html',$data);
    }

    public function addhandle(){
        $this->form_validation->set_rules('cat_name','分类名称','required');
        if($this->form_validation->run() == false){
            $data['wait_time'] = 5;
            $data['url'] = site_url('admin/category/add');
            $data['message'] = validation_errors();
            $this->load->view('message.html',$data);
        }else{
            $data['cat_name'] = $this->input->post('cat_name');
            $data['pid'] = $this->input->post('parent_id');
            $data['unit'] = $this->input->post('measure_unit');
            $data['sort'] = $this->input->post('sort_order');
            $data['is_show'] = $this->input->post('is_show');
            $data['cat_desc'] = $this->input->post('cat_desc');
            if($this->Category_model->cat_add($data)){
                $data['wait_time'] = 5;
                $data['url'] = site_url('admin/category/index');
                $data['message'] = '添加商品分类成功!';
                $this->load->view('message.html',$data);
            }else{
                $data['wait_time'] = 5;
                $data['url'] = site_url('admin/category/add');
                $data['message'] = '添加商品分类失败!';
                $this->load->view('message.html',$data);
            }
        }
    }

    public function edit($id){
        $data['cats'] = $this->Category_model->cat_list();
        $data['current_cat'] = $this->Category_model->cat_one($id);
        $this->load->view('cat_edit.html',$data);
    }

    public function edithandle(){
        $id = $this->input->post('id');
        $cid = $this->Category_model->cat_list($id);
        $cids = [];
        foreach($cid as $v){
            $cids[] = $v['id'];
        }
        $pid = $this->input->post('parent_id');
        if($pid == $id || in_array($pid,$cids)){
            $data['wait_time'] = 5;
            $data['url'] = site_url('admin/category/edit') . '/' .$id;
            $data['message'] = '添加商品分类失败!';
            $this->load->view('message.html',$data);
        }else{
            $data['cat_name'] = $this->input->post('cat_name');
            $data['pid'] = $this->input->post('parent_id');
            $data['unit'] = $this->input->post('measure_unit');
            $data['sort'] = $this->input->post('sort_order');
            $data['is_show'] = $this->input->post('is_show');
            $data['cat_desc'] = $this->input->post('cat_desc');
            if($this->Category_model->cat_update($data,$id)){
                $data['wait_time'] = 5;
                $data['url'] = site_url('admin/category/index');
                $data['message'] = '更新商品分类成功!';
                $this->load->view('message.html',$data);
            }else{
                $data['wait_time'] = 5;
                $data['url'] = site_url('admin/category/edit') . '/' . $id;
                $data['message'] = '更新商品分类失败!';
                $this->load->view('message.html',$data);
            }
        }
    }
}