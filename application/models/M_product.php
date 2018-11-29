<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_product extends CI_Model{

	public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function get($params=array()){
        if(isset($params['active'])){
            $this->db->where('active',$params['active']);
        }

		$res = $this->db->get('master_product');
		return $res;
    }

    function add($params=array()){
        if(isset($params['id_product'])){
            unset($params['id_product']);
        }
        $res = $this->db->insert('master_product',$params);
        return $res;
    }

    function upd($params=array()){
        if(isset($params['id_product'])){
            $this->db->where('id_product',$params['id_product']);
        }
        unset($params['id_product']);

        $res = $this->db->update('master_product',$params);
        return $res;
    }

    function del($params=array()){
        if(isset($params['id_product'])){
            $this->db->where('id_product',$params['id_product']);
        }
        unset($params['id_product']);

        $res = $this->db->delete('master_product',$params);
        return $res;
    }
}