<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model{

    const TABLENAME  = "category";

    public function cat_list($pid = 0){
        $query = $this->db->get(self::TABLENAME);
        $result = $query->result_array();
        return $this->_tree($result,$pid);
    }

    private function _tree($arr,$pid = 0,$level = 0){
        static $tree = [];
        foreach($arr as $v){
            if($v['pid']  == $pid){
                $v['level'] = $level;
                $tree[] = $v;
                $this->_tree($arr,$v['id'],$level+1);
            }
        }
        return $tree;
    }

    public function cat_add($data){
        return $this->db->insert(self::TABLENAME,$data);
    }

    public function cat_one($id){
        $where['id'] = $id;
        $query = $this->db->where($where)->get(self::TABLENAME);
        return $query->row_array();
    }

    public function cat_update($data,$id){
        $where['id'] = $id;
        return $this->db->where($where)->update(self::TABLENAME,$data);
    }

    public function cat_front(){
        $query = $this->db->get(self::TABLENAME);
        $cats = $query->result_array();
        return $this->list_cat($cats);
    }

    public function list_cat($arr,$pid = 0){
        $child = [];
        foreach($arr as $k => $v){
            if($v['pid'] == $pid){
                $child[] = $v;
            }
        }
        if(empty($child)){
            return null;
        }
        foreach($child as $k => $v){
            $current_child = $this->list_cat($arr,$v['id']);
            if($current_child != null){
                $child[$k]['child'] = $current_child;
            }
        }
        return $child;
    }
}