<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Downtime extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->check_access(1);
        $this->load->model('m_problem');
    }

    function get(){
        $data = $this->m_problem->get()->result();
        $out = array(
            'data' => $data
        );
		echo json_encode($out);
    }

    function simpan(){
        $params = array(
            'id_problem' => (int) $this->input->post('id_problem'),
            'kode_downtime' => $this->input->post('kode_downtime'),
            'nama_problem' => $this->input->post('nama_problem'),
            'keterangan_problem' => $this->input->post('keterangan_problem'),
            'type' => $this->input->post('type')
        );

        $res = false;
        if($params['id_problem']=='' || $params['id_problem']==0){
            $res = $this->m_problem->add($params);
        } else {
            $res = $this->m_problem->upd($params);
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
            'id_problem' => $this->input->post('id_problem')
        );
        $res = $this->m_problem->del($params); 
        if($res){
            $output = array('success'=>true,'msg'=>'Data berhasil dihapus');
        } else {
            $output = array('success'=>false,'msg'=>'Data gagal dihapus');
        }
        echo json_encode($output);
    }
}