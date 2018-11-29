<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_problem extends CI_Model{

	public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function get($params=array()){
        if(isset($params['status'])){
            $this->db->where('status',1);
        }
        $this->db->order_by('type','asc');
		$res = $this->db->get('master_problem');
		return $res;
    }

    function get_byid($params=array()){
        if(isset($params['id_problem'])){
            $this->db->where('id_problem',$params['id_problem']);
        }
        $res = $this->db->get('master_problem');
        return $res->first_row();
    }

    function add($params=array()){
        if(isset($params['id_problem'])){
            unset($params['id_problem']);
        }
        $res = $this->db->insert('master_problem',$params);
        return $res;
    }

    function upd($params=array()){
        if(isset($params['id_problem'])){
            if($params['id_problem']!=0){
                $this->db->where('id_problem',$params['id_problem']);
            } else {
                return false;
                exit;
            }
        } else {
            return false;
            exit;
        }
        unset($params['id_problem']);

        $res = $this->db->update('master_problem',$params);
        return $res;
    }

    function del($params=array()){
        if(isset($params['id_problem'])){
            $this->db->where('id_problem',$params['id_problem']);
        }
        unset($params['id_problem']);

        $res = $this->db->delete('master_problem',$params);
        return $res;
    }
}