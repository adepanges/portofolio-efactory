<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Product extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->check_access(1);
        $this->load->model('m_product');
    }

    function get(){
        $data = $this->m_product->get()->result();
        $out = array(
            'data' => $data
        );
		echo json_encode($out);
    }

    function simpan(){
        $params = array(
            'id_product' => (int) $this->input->post('id_product'),
            'product_name' => $this->input->post('product_name'),
            'duration' => $this->input->post('duration'),
            'active' => (int) $this->input->post('active')
        );

        $res = false;
        if($params['id_product']=='' || $params['id_product']==0){
            $res = $this->m_product->add($params);
        } else {
            $res = $this->m_product->upd($params);
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
            'id_product' => $this->input->post('id_product')
        );
        $res = $this->m_product->del($params); 
        if($res){
            $output = array('success'=>true,'msg'=>'Data berhasil dihapus');
        } else {
            $output = array('success'=>false,'msg'=>'Data gagal dihapus');
        }
        echo json_encode($output);
    }
}