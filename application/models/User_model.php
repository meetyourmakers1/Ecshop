<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{

    const TABLENAME = 'user';

    public function user_add($data){
        return $this->db->insert(self::TABLENAME,$data);
    }

    public function get_user($username,$password){
        $where['username'] = $username;
        $where['password'] = md5($password);
        $query = $this->db->where($where)->get(self::TABLENAME);
        return $query->row_array();
    }
}