<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand_model extends CI_Model{

    const TABLENAME = 'brand';

    public function brand_add($data){
        return $this->db->insert(self::TABLENAME,$data);
    }

    public function brand_list(){
        $query = $this->db->get(self::TABLENAME);
        return $query->result_array();
    }
}