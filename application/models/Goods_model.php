<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goods_model extends CI_Model {

    const TABLENAME = 'goods';

    public function goods_add($data){
        $query = $this->db->insert(self::TABLENAME,$data);
        return $query ? $this->db->insert_id() : false;
    }

    public function goods_best(){
        $where['is_best'] = 1;
        $query = $this->db->where($where)->get(self::TABLENAME);
        return $query->result_array();
    }

    public function goods_one($goods_id){
        $where['id'] = $goods_id;
        $query = $this->db->where($where)->get(self::TABLENAME);
        return $query->row_array();
    }
}