<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class User extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->check_access(1);
        $this->load->model('m_user');
    }

    function get(){
        $data = $this->m_user->get()->result();
        $out = array(
            'data' => $data
        );
		echo json_encode($out);
    }

    function simpan(){
        $params = array(
            'id_user' => (int) $this->input->post('id_user'),
            'username' => $this->input->post('username'),
            'password' => md5(trim($this->input->post('password'))),
            'nama' => $this->input->post('nama'),
            'id_hakakses' => (int) $this->input->post('id_hakakses')
        );

        if(strlen(trim($this->input->post('password')))==32){
            unset($params['password']);
        }

        $res = false;
        if($params['id_user']=='' || $params['id_user']==0){
            $res = $this->m_user->add($params);
        } else {
            $res = $this->m_user->upd($params);
        }
        
        if($res){
            $output = array('success'=>true,'msg'=>'Data berhasil disimpan');
        } else {
            $output = array('success'=>false,'msg'=>'Data gagal disimpan');
        }
        echo json_encode($output);   
    }

    function del()
    {
        $params = array(
            'id_user' => $this->input->post('id_user')
        );
        $res = $this->m_user->del($params); 
        if($res){
            $output = array('success'=>true,'msg'=>'Data berhasil dihapus');
        } else {
            $output = array('success'=>false,'msg'=>'Data gagal dihapus');
        }
        echo json_encode($output);
    }
}