<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends Home_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('cart');
    }

    public function index(){
        $data['carts'] = $this->cart->contents();
        $this->load->view('flow.html',$data);
    }

    public function add(){
        $data['goods_id'] = $this->input->post('goods_id');
        $data['goods_name'] = $this->input->post('goods_name');
        $data['goods_number'] = $this->input->post('goods_nums');
        $data['goods_price'] = $this->input->post('shop_price');
        $carts = $this->cart->contents();
        foreach ($carts as $cart) {
            if ($cart['id'] == $data['id']){
                $data['goods_number'] += $cart['qty'];
            }
        }
        if ($this->cart->insert($data)) {
            redirect('cart/show');
        } else {

        }
    }

    public function del($rowid){
        $data['rowid'] = $rowid;
        $data['goods_number'] = 0;
        $this->cart->update($data);
        redirect('cart/index');
    }
}