<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_log extends CI_Model{
	public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function cek_log($params=array()){
        if(isset($params['username'])){
            $this->db->where('username',$params['username']);
        }

        if(isset($params['password'])){
            $this->db->where('password',$params['password']);
        }

        $this->db->where('status',1);
        $this->db->join('trans_userhakakses','master_user.id_user=trans_userhakakses.id_user and trans_userhakakses.id_modul = '.$this->config->item('id_modul'),'left');
        $this->db->join('master_hakakses','trans_userhakakses.id_hakakses=master_hakakses.id_hakakses','left');

        $res = $this->db->get('master_user');
        return $res;
    }

    function cek_active_machine($params=array()){
        if(isset($params['id_user'])){
            $this->db->where('id_user',$params['id_user']);
        }
        $this->db->where('active',1);
        $this->db->where('waktu_selesai is null');
        $res = $this->db->get('trans_kegiatan');
        return $res;
    }

    function get_detail($params=array()){
        if(isset($params['id_mesin'])){
            $this->db->where('id_mesin',$params['id_mesin']);
        }
        $res = $this->db->get('master_user')->first_row();
        return $res;
    }

    function add($params=array()){
        $res = $this->db->insert('master_user',$params);
        return $res;
    }

    function upd($params=array()){
        if(isset($params['id_mesin'])){
            $this->db->where('id_mesin',$params['id_mesin']);
        }
        unset($params['id_mesin']);

        $res = $this->db->update('master_user',$params);
        return $res;
    }
}