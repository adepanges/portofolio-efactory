<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_user extends CI_Model{

	public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function get($params=array()){
        if(isset($params['status'])){
            $this->db->where('status',1);
        }
        $this->db->join('trans_userhakakses','master_user.id_user=trans_userhakakses.id_user','left');
        $this->db->join('master_hakakses','trans_userhakakses.id_hakakses=master_hakakses.id_hakakses','left');
        $this->db->order_by('master_user.id_user','asc');
		$res = $this->db->get('master_user');
		return $res;
    }

    function add($params=array()){
        if(isset($params['id_user'])){
            unset($params['id_user']);
        }
        $id_hakakses = $params['id_hakakses'];
        unset($params['id_hakakses']);

        $res = $this->db->insert('master_user',$params);

        if($res){
            $params_h = array(
                'id_user' => $this->db->insert_id(),
                'id_modul' => $this->config->item('id_modul'),
                'id_hakakses' => $id_hakakses
            );
            $res = $this->db->insert('trans_userhakakses',$params_h);
        }
        return $res;
    }

    function upd($params=array()){
        if(isset($params['id_user'])){
            $this->db->where('id_user',$params['id_user']);
        }
        $id_user = $params['id_user'];
        unset($params['id_user']);

        $id_hakakses = $params['id_hakakses'];
        unset($params['id_hakakses']);

        $res = $this->db->update('master_user',$params);
        if($res){
            $this->db->where('id_user',$id_user);
            $this->db->where('id_modul',$this->config->item('id_modul'));
            $params_h = array(
                'id_hakakses' => $id_hakakses
            );
            $res = $this->db->update('trans_userhakakses',$params_h);
        }

        return $res;
    }

    function del(){
        if(isset($params['id_user'])){
            $this->db->where('id_user',$params['id_user']);
        }
        unset($params['id_user']);

        $res = $this->db->delete('master_user',$params);
        return $res;
    }
}