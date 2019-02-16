<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goods extends Admin_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('Type_model');
        $this->load->model('Attribute_model');
        $this->load->model('Category_model');
        $this->load->model('Brand_model');
        $this->output->enable_profiler(TRUE);
    }

    public function index(){
        $this->load->view('goods_list.html');
    }

    public function add(){
        $data['types'] = $this->Type_model->get_types();
        $data['cats'] = $this->Category_model->cat_list();
        $data['brands'] = $this->Brand_model->brand_list();
        $this->load->view('goods_add.html',$data);
    }

    public function edit(){
        $this->load->view('goods_edit.html');
    }

    public function attr(){
        $type_id = $this->input->get('type_id');
        $attrs = $this->Attribute_model->get_attrs($type_id);
        $html = '';
        foreach($attrs as $attr){
            $html .= "<tr>";
            $html .= "<td class='label'>" . $attr['attr_name'] . "</td>";
            $html .= "<td>";
            $html .= "<input type='hidden' name='attr_id_list[]' value='" . $attr['id']  . "'>";
            switch($attr['attr_input_type']){
                case 0:
                    $html .= "<input name='attr_value_list[]' type='text' size='40'>";
                    break;
                case 1:
                    $attr_value_arr = explode(PHP_EOL,$attr['attr_value']);
                    $html .= "<select name='attr_value_list[]'>";
                    $html .= "<option value=''>请选择...</option>";
                    foreach($attr_value_arr as $attr_value){
                        $html .= "<option value='$attr_value'>" . $attr_value  . "</option>";
                    }
                    $html .= "</select>";
                    break;
                case 2:
                    break;
                default:
                    break;
            }
            $html .= "</td>";
            $html .= "</tr>";
        }
        echo $html;
    }

    public function addhandle(){
        $data['goods_name'] = $this->input->post('goods_name');
        $data['goods_sn'] = $this->input->post('goods_sn');
        $data['cat_id'] = $this->input->post('cat_id');
        $data['brand_id'] = $this->input->post('brand_id');
        $data['market_price'] = $this->input->post('market_price');
        $data['shop_price'] = $this->input->post('shop_price');
        $data['promote_price'] = $this->input->post('promote_price');
        $data['promote_start_time'] = strtotime($this->input->post('promote_start_time'));
        $data['promote_end_time'] = strtotime($this->input->post('promote_end_time'));
        $data['goods_desc'] = $this->input->post('goods_desc');
        $data['goods_number'] = $this->input->post('goods_number');
        $data['goods_brief'] = $this->input->post('goods_brief');
        $data['is_best'] = $this->input->post('is_best');
        $data['is_new'] = $this->input->post('is_new');
        $data['is_hot'] = $this->input->post('is_hot');
        $data['is_onsale'] = $this->input->post('is_onsale');
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 1024;
        $this->load->library('upload',$config);
        if($this->upload->do_upload('goods_img')){
            $uploadinfo = $this->upload->data();
            $data['goods_img'] = $uploadinfo['file_name'];
            $config_img['source_img'] = './upload/'.$uploadinfo['file_name'];
            $config_img['create_thumb'] = TRUE;
            $config_img['maintain_ratio'] = TRUE;
            $config_img['width'] = 100;
            $config_img['height'] = 100;
            $this->load->library('image_lib',$config_img);
            if($this->image_lib->resize()){
                $data['goods_thumb'] = $uploadinfo['raw_name'] . $this->image_lib->thumb_marker . $uploadinfo['file_ext'];
                if($goods_id = $this->Goods_model->goods_add()){
                    $attr_ids = $this->input->post('attr_id_list');
                    $attr_values = $this->input->post('attr_value_list');
                    foreach($attr_values as $k => $v){
                        if(!empty($v)){
                            $data2['goods_id'] = $goods_id;
                            $data2['attr_id'] = $attr_ids[$k];
                            $data2['attr_value'] = $v;
                            $this->db->insert('goods_attr',$data2);
                        }
                    }
                    $data['wait_time'] = 5;
                    $data['url'] = site_url('admin/goods/index');
                    $data['message'] = '添加商品成功!';
                    $this->load->view('message.html',$data);
                }else{
                    $data['wait_time'] = 5;
                    $data['url'] = site_url('admin/goods/add');
                    $data['message'] = '添加商品失败!';
                    $this->load->view('message.html',$data);
                }
            }else{
                $data['wait_time'] = 5;
                $data['url'] = site_url('admin/goods/add');
                $data['message'] = $this->image_lib->display_errors();
                $this->load->view('message.html',$data);
            }
        }else{
            $data['wait_time'] = 5;
            $data['url'] = site_url('admin/goods/add');
            $data['message'] = $this->upload->display_errors();
            $this->load->view('message.html',$data);
        }
    }
}