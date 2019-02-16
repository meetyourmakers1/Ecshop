<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->switch_themes_on();
        $this->load->helper('captcha');
        $this->load->library('form_validation');
    }

    public function index(){
        $this->load->view('login.html ');
    }

    public function verifycode(){
        $data = [
            'word' => rand(1000,9999)
        ];
        $captcha = create_captcha($data);
        $this->session->set_userdata('captcha',$captcha);
    }

    public function signin(){
        $this->form_validation->set_rules('username','用户名','required');
        $this->form_validation->set_rules('password','密码','required');

        $captcha = strtolower($this->input->post('captcha'));

        $session_captcha = strtolower($this->session->userdata('captcha'));

        if($captcha === $session_captcha){
            if($this->form_validation->run() == false){
                $data['wait_time'] = 5;
                $data['url'] = site_url('admin/login/index');
                $data['message'] = validation_errors();
                $this->load->view('message.html',$data);
            }else{
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                if($username == 'admin' && $password == 'admin'){
                    $this->session->set_userdata('username',$username);
                    redirect('admin/admin/index');
                }else{
                    $data['wait_time'] = 5;
                    $data['url'] = site_url('admin/login/index');
                    $data['message'] = '用户名或密码错误,请稍候重试!';
                    $this->load->view('message.html',$data);
                }
            }
        }else{
            $data['wait_time'] = 5;
            $data['url'] = site_url('admin/login/index');
            $data['message'] = '验证码错误,请稍候重试!';
            $this->load->view('message.html',$data);
        }
    }

    public function loginout(){
        $this->session->unset_userdata('username');
        $this->session->sess_destroy();
        redirect('admin/login/index');
    }
}
