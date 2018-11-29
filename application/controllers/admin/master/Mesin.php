<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mesin extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->check_access(1);
        $this->load->model('m_mesin');
    }

    function get(){
        $data = $this->m_mesin->get_machine_only()->result();
        $out = array(
            'data' => $data
        );
		echo json_encode($out);
    }

    function simpan(){
        $params = array(
            'id_mesin' => (int) $this->input->post('id_mesin'),
            'kode_mesin' => $this->input->post('kode_mesin'),
            'nama_mesin' => $this->input->post('nama_mesin'),
            'keterangan_mesin' => $this->input->post('keterangan_mesin')
        );

        $res = false;
        if($params['id_mesin']=='' || $params['id_mesin']==0){
            $res = $this->m_mesin->add($params);
        } else {
            $res = $this->m_mesin->upd($params);
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
            'id_mesin' => $this->input->post('id_mesin')
        );
        $res = $this->m_mesin->del($params); 
        if($res){
            $output = array('success'=>true,'msg'=>'Data berhasil dihapus');
        } else {
            $output = array('success'=>false,'msg'=>'Data gagal dihapus');
        }
        echo json_encode($output);
    }
}