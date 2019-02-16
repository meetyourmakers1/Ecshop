<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_model extends CI_Model {

    const TABLENAME = 'type';

    public function type_add($data){
        return $this->db->insert(self::TABLENAME,$data);
    }

    public function type_list($limit = '',$offset = ''){
        $query = $this->db->limit($limit,$offset)->get(self::TABLENAME);
        return $query->result_array();
    }

    public function type_count(){
        return $this->db->count_all(self::TABLENAME);
    }

    public function get_types(){
        $query = $this->db->get(self::TABLENAME);
        return $query->result_array();
    }
}