<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class App extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->check_access('1,2');
        $this->load->model('m_detailkegiatan');
        $this->load->model('m_mesin');

        $this->set_downtime_duration();
    }

    function index(){

        $this->load->library('template');
        
        $data['mesin'] = $this->get_machine();

        $this->template->display('inc/supervisor/machine',$data);
    }

    private function set_downtime_duration(){
        $params = array(
            'status' => 3,
            'downtime_duration' => 'IS_NULL'
        );

        $res = $this->m_detailkegiatan->get($params)->result();
        foreach ($res as $key => $v) {
            $time_mulai = (int) strtotime($v->waktu_mulai);
            $time_selesai = (int) strtotime($v->waktu_selesai);
            $duration = $time_selesai - $time_mulai;
            $params_upd = array(
                'id_detailkegiatan' => $v->id_detailkegiatan,
                'downtime_duration' => $duration
            );
            $res = $this->m_detailkegiatan->upd($params_upd);
        }
    }

    function get_machine_ajax(){
        $data = $this->get_machine();
        if(count($data)>0){
            $out = array('success' => true, 'data' => $data);
        } else {
            $out = array('success' => false, 'data' => array());
        }
        echo json_encode($out);
    }

    private function get_machine(){
        $temp1 = $this->m_mesin->get()->result_array();
        $out = array();
        $i=1;
        foreach ($temp1 as $d) {
            $temp2 = $d;
            $temp2['idcmp'] = $i.'-'.str_replace(' ', '-', $d['kode_mesin']);
            $out[] = $temp2;
            $i++;
        }
        return $out;
    }

    function cek_machine(){
        $params = array(
            'status_mesin' => 1
        );
        $res1 = $this->m_mesin->get($params);
        $params = array(
            'status_mesin' => 2
        );
        $res2 = $this->m_mesin->get($params);
        $params = array(
            'status_mesin' => 3
        );
        $res3 = $this->m_mesin->get($params);



        if($res1 && $res2){
            if($res1->num_rows()>0 || $res2->num_rows()>0){
                $out = array(
                    'success'=>true,
                    'machine_stopped'=>$res1->num_rows(),
                    'machine_running'=>$res2->num_rows(),
                    'machine_downtime'=>$res3->num_rows()
                );
            } else {
                $out = array('success'=>false,'machine_running'=>0,'machine_stopped'=>0);
            }
        } else {
            $out = array('success'=>false,'machine_running'=>0,'machine_stopped'=>0);
        }

        echo json_encode($out);
    }

    function get_machine_problem(){
        $action = ((int) $this->input->post('action_confirm'));
        if($action==1){
            $status = 1;
        } else {
            $status = 2;
        }
        $params = array(
            'id_keg' => (int) $this->input->post('id_keg'),
            'status' => $status
        );
        $res = $this->m_detailkegiatan->get_byid($params);
        if(count($res)){
            $out = array('success'=>true,'data'=>$res);
        } else {
            $out = array('success'=>false,'data'=>$params);
        }
        echo json_encode($out);
    }

    function confirm_problem(){
        $params_detail = array(
            'id_detailkegiatan' => (int) $this->input->post('id_detailkegiatan'),
            'status' => 2,
            'waktu_confirm' => date('Y-m-d H:i:s')
        );

        $params_machine = array(
            'id_mesin' => (int) $this->input->post('id_mesin'),
            'status_mesin' => 4
        );

        $res = $this->m_detailkegiatan->upd($params_detail);
        if($res){
            $res2 = $this->m_mesin->upd($params_machine);
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

    function get_detail_machine(){
        $this->load->model('m_kegiatan');

        $params = array(
            'id_keg' => (int) $this->input->post('id_keg')
        );

        $machine_kegiatan = $this->m_kegiatan->get_byid($params);
        $machine_kegiatan->time_mulai = strtotime($machine_kegiatan->waktu_mulai);

        $time_mulai = (int) $machine_kegiatan->time_mulai;
        $duration = (int) $machine_kegiatan->duration; // minutes
        $total_downtime = (int) $machine_kegiatan->total_downtime; // second

        $jam_mulai = '-';
        $time_durasi_selesai = 0;
        $time_estimasi_selesai = 0;
        $jam_estimasi_selesai = '-';
        $running = 0;
        $remaining = 0;

        if($time_mulai){
            $jam_mulai = date('d F Y H:i:s', $time_mulai);
            $running = (time()-$time_mulai);
            $time_durasi_selesai = ($duration*60)+$total_downtime;
            $time_estimasi_selesai = $time_mulai + $time_durasi_selesai;
            $remaining = $time_estimasi_selesai - time();
            $jam_estimasi_selesai = date('d F Y H:i:s',$time_estimasi_selesai);
        }
        $out = array(
            'success' => true,
            'data' => array(
                'estimated' => $jam_estimasi_selesai
            )
        );
        echo json_encode($out);
    }

    function resolv_problem(){
        $params_detail = array(
            'id_detailkegiatan' => (int) $this->input->post('id_detailkegiatan'),
            'status' => 3,
            'waktu_selesai' => date('Y-m-d H:i:s')
        );

        $params_machine = array(
            'id_mesin' => (int) $this->input->post('id_mesin'),
            'status_mesin' => 2
        );

        $res = $this->m_detailkegiatan->upd($params_detail);
        if($res){
            $res2 = $this->m_mesin->upd($params_machine);
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
}