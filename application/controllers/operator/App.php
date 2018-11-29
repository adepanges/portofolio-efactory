<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class App extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->check_access(3);
        $this->load->model('m_mesin');
    }

    function index(){
        $this->load->library('template');
        $this->load->model('m_product');
        
        $id_mesin = (int) $this->session->userdata('id_mesin');
        $id_keg = (int) $this->session->userdata('id_keg');
        if($id_mesin!=0 || $id_keg!=0){
            redirect('operator/app/machine');
        }

        $params = array(
            'status_mesin' => 1
        );
        $temp1 = $this->m_mesin->get($params)->result_array();

        $out = array();
        foreach ($temp1 as $d) {
            $temp2 = $d;
            $temp2['idcmp'] = str_replace(' ', '', $d['kode_mesin']);
            if(((int) $temp2['active'])!=1){
                $out[] = $temp2;
            }
        }
        $params_product = array(
            'active' => 1
        );
        $data['product'] =  $temp1 = $this->m_product->get($params_product)->result();
        $data['mesin'] = $out;

        $this->template->display('inc/operator/all_machine_off',$data);
    }


    function machine(){
        $id_mesin = (int) $this->session->userdata('id_mesin');
        $id_keg = (int) $this->session->userdata('id_keg');
        if($id_mesin==0 || $id_keg==0){
            redirect('operator');
        }

        $this->load->library('template');
        $this->load->model('m_kegiatan');
        $this->load->model('m_problem');
        $this->load->model('m_detailkegiatan');

        $params = array(
            'id_mesin' => $id_mesin,
            'id_keg' => $id_keg
        );

        $data = array();
        $data['machine_kegiatan'] = $this->m_kegiatan->get_byid($params);
        $data['machine_kegiatan']->time_mulai = strtotime($data['machine_kegiatan']->waktu_mulai);

        unset($params['id_keg']);
        $data['machine'] = $this->m_mesin->get_byid($params);
        $data['problem'] = $this->m_problem->get()->result();
        $params2 = array(
            'id_keg' => $id_keg,
            'status' => 2
        );
        $dt_now = $this->m_detailkegiatan->get($params2);

        unset($params2['status']);
        $dt = $this->m_detailkegiatan->get($params2);

        $data['machine_kegiatan_detail'] = $dt->result();
        $data['machine_kegiatan_detail_count'] = $dt->num_rows();

        $data['machine_down_time'] = $dt_now->first_row();

        $this->template->display('inc/operator/detail_machine_on',$data);
    }

    function start_machine($id_mesin=0){
        $this->load->model('m_kegiatan');

        $params_kegiatan = array(
            'id_keg' => $this->session->userdata('id_keg'),
            'waktu_mulai' => date('Y-m-d H:i:s')
        );

        $params_mesin = array(
            'id_mesin' => $this->session->userdata('id_mesin'),
            'status_mesin' => 2
        );

        $res1 = $this->m_kegiatan->upd($params_kegiatan);

        if($res1){
            $res2 = $this->m_mesin->upd($params_mesin);
            if($res2){
                $out = array('success'=>true);
            } else {
                $out = array('success'=>false);
            }
        } else {
            $out = array('success'=>false);
        }
        echo json_encode($out);
    }

    function stop_machine($id_mesin=0){
        $this->load->model('m_kegiatan');

        $params_kegiatan = array(
            'id_mesin' => $this->session->userdata('id_mesin'),
            'id_keg' => $this->session->userdata('id_keg'),
            'active' => 0,
            'waktu_selesai' => date('Y-m-d H:i:s')
        );

        $params_mesin = array(
            'id_mesin' => $this->session->userdata('id_mesin'),
            'status_mesin' => 1
        );

        $res1 = $this->m_kegiatan->upd($params_kegiatan);

        if($res1){
            $res2 = $this->m_mesin->upd($params_mesin);
            if($res2){
                $data = array(
                    'id_mesin' => 0,
                    'id_keg' => 0
                );
                $this->session->set_userdata($data);
                $out = array('success'=>true);
            } else {
                $out = array('success'=>false);
            }
        } else {
            $out = array('success'=>false);
        }
        echo json_encode($out);
    }

    function operate_machine($id_mesin=0){
        $id_user = (int) $this->session->userdata('id_user');
        $params = array(
            'id_user' => $id_user,
            'id_mesin' => (int) $id_mesin,
            // 'waktu_mulai' => date('Y-m-d H:i:s'),
            'kode_session' => base64_encode(time().'.'.$id_mesin),
            'kode_batch' => $this->input->post('kode_batch'),
            'id_product' => (int) $this->input->post('id_product'),
        );

        $params2 = array(
            'id_mesin' => (int) $id_mesin,
            'status_mesin' => 2
        );

        if($params['id_mesin']==0){
            $this->root_check_access();
        }

        $this->load->model('m_kegiatan');

        $res = $this->m_kegiatan->add($params);
        $id_keg = $this->db->insert_id();

        if($res){
            // $res2 = $this->m_mesin->upd($params2);
            $res2 = true;
            if($res2){
                $data = array(
                    'id_mesin' => $params['id_mesin'],
                    'id_keg' => $id_keg,
                    'kode_session' => $params['kode_session']
                );
                $this->session->set_userdata($data);
                $out = array('success'=>true);
            } else {
                $out = array('success'=>false);
            }
        } else {
            $out = array('success'=>false);
        }
        echo json_encode($out);
    }

    function machine_end_dt(){
        $this->load->model('m_detailkegiatan');

        $params1 = array(
            'id_detailkegiatan' => (int) $this->input->post('id_detailkegiatan'),
            'status' => 3,
            'waktu_selesai' => date('Y-m-d H:i:s')
        );

        $time_mulai = (int) $this->input->post('time_mulai');
        $status = 1;
        if($time_mulai>0){
            $status = 2;
        }

        $params2 = array(
            'id_mesin' => (int) $this->input->post('id_mesin'),
            'status_mesin' => $status
        );
        
        $res1 = $this->m_detailkegiatan->upd($params1);
        // $res1 = false;
        if($res1){
            $res2 = $this->m_mesin->upd($params2);
            if($res2){
                $out = array('success'=>true);
            } else {
                $out = array('success'=>false);
            }
        } else {
            $out = array('success'=>false,'params1'=>$params1,'params2'=>$params2);
        }
        echo json_encode($out);
    }

    function machine_add_downtime(){
        $id_mesin = $this->session->userdata('id_mesin');
        $id_keg = $this->session->userdata('id_keg');

        $this->load->model('m_detailkegiatan');
        $this->load->model('m_problem');
        
        $params = array(
            'id_keg' => $id_keg,
            'id_problem' => $this->input->post('id_problem'),
            'waktu_mulai' => date('Y-m-d H:i:s'),
            'keterangan_detailkeg' => $this->input->post('keterangan')
        );

        $data_dt = $this->m_problem->get_byid($params);

        $params2 = array(
            'id_mesin' => $id_mesin,
            'status_mesin' => 3
        );

        if($data_dt->type==1){
            $params['status'] = 2;
            $params['waktu_confirm'] = date('Y-m-d H:i:s');
            $params2['status_mesin'] = 4;
        }

        $res = $this->m_detailkegiatan->add($params);
        if($res){
            $res2 = $this->m_mesin->upd($params2);

            redirect('operator');
        } else {
            redirect('operator?fail_add_problem_machine');
        }
    }

    function cek_status_machine(){
        $params = array(
            'id_mesin' => (int) $this->input->post('id_mesin')
        );
        $res = $this->m_mesin->get_byid($params);
        if(count($res)>0){
            $out = array('success'=>true,'data'=>$res);
        } else {
            $out = array('success'=>false,'data'=>array());
        }
        echo json_encode($out);
    }
}