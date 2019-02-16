<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attribute_model extends CI_Model{
    const TABLENAME = 'attribute';

    public function attr_add($data){
        return $this->db->insert(self::TABLENAME,$data);
    }

    public function attr_list(){
        $query = $this->db->get(self::TABLENAME);
        return $query->result_array();
    }

    public function get_attrs($type_id){
        $where['type_id'] = $type_id;
        $query = $this->db->where($where)->get(self::TABLENAME);
        return $query->result_array();
    }
}