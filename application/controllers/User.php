<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Home_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_model');
    }

    public function regist(){
        $this->load->view('register.html');
    }

    public function login(){
        $this->load->view('login.html');
    }

    public function registhandle(){
        $this->form_validation->set_rules('username','用户名','required');
        $this->form_validation->set_rules('password','密码','required|md5|min_length[6]|max_length[10]');
        $this->form_validation->set_rules('repassword','重复密码','required|matches[password]');
        $this->form_validation->set_rules('email','电子邮箱','required|valid_email');
        if($this->form_validation->run() == false){

        }else{
            $data['username'] = $this->input->post('username');
            $data['password'] = $this->input->post('password');
            $data['email'] = $this->input->post('email');
            $data['reg_time'] = time();
            if($this->User_model->user_add($data)){

            }else{

            }
        }
    }

    public function signin(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if($userinfo = $this->User_model->get_user($username,$password)){
            $this->session->set_userdata('userinfo',$userinfo);
            redirect('home/index');
        }else{

        }
    }

    public function logout(){
        $this->session->unset_userdata('userinfo');
        redirect('home/index');
    }
}