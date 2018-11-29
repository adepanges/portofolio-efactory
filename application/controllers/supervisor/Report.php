<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Report extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->check_access('1,2');
        $this->load->model('m_mesin');
        $this->load->model('m_kegiatan');
        $this->set_duration();
    }

    private function set_duration(){
        $params = array(
            'duration_life_is_null' => true
        );

        $data = $this->m_kegiatan->get($params)->result();

        foreach ($data as $k) {
            $params_d = array(
                'id_keg' => $k->id_keg
            );
            $data_d = $this->m_kegiatan->get_byid($params_d);
            $time_selesai = strtotime($data_d->waktu_selesai);
            $time_mulai = strtotime($data_d->waktu_mulai);
            $duration_life = ($time_selesai - $time_mulai)-$data_d->total_downtime;
            $prosentase = 0;
            // $prosentase = round(((($duration_life/60)/$data_d->duration)*100),2);
            $params_upd = array(
                'id_keg' => $data_d->id_keg,
                'duration_life' => $duration_life,
                'prosentase' => $prosentase
            );
            
            $this->m_kegiatan->upd($params_upd);
        }

        // exit;
    }

    function index(){

        $this->load->library('template');
        
        $data['mesin'] = $this->m_mesin->get_machine_only()->result();

        $this->template->display('inc/supervisor/report',$data);
    }

    function down_time(){
        $this->load->library('template');
        
        $data['mesin'] = $this->m_mesin->get_machine_only()->result();

        $this->template->display('inc/supervisor/report_down_time',$data);   
    }

    private function _get_data_dt(){
        $this->load->model('m_detailkegiatan');

        $tgl_mulai = $this->input->post('tgl_mulai');
        $tgl_mulai = ($tgl_mulai!='')?$tgl_mulai:$this->input->get('tgl_mulai');

        if($tgl_mulai=='' && !(isset($_POST['tgl_mulai']) || isset($_GET['tgl_mulai']))){
            $tgl_mulai = date('d/m/Y');
        }

        $id_mesin = $this->input->post('id_mesin');
        $id_mesin = ($id_mesin!='')?$id_mesin:$this->input->get('id_mesin');

        $params = array(
            'tgl_mulai' => $tgl_mulai,
            'id_mesin' => $id_mesin,
            'downtime_duration' => 'IS_NOT_NULL'
        );


        $data = $this->m_detailkegiatan->get($params)->result();

        $res = array();
        foreach ($data as $k) {
            $tmp = $k;
            $tmp->tanggal = date('d/m/Y',strtotime($k->waktu_mulai));
            $tmp->jam_mulai = date('H:i',strtotime($k->waktu_mulai));
            $tmp->jam_selesai = date('H:i',strtotime($k->waktu_selesai));
            $tmp->downtime_duration = round($k->downtime_duration/60);
            $tmp->kategori = '';
            if($k->type==1){
                $tmp->kategori = 'PLANNED DT';
            } else if($k->type==2){
                $tmp->kategori = 'UNPLANNED DT';
            }
            $res[] = $tmp;
        }

        return $res;
    }

    private function _get_data(){
        $tgl_mulai = $this->input->post('tgl_mulai');
        $tgl_mulai = ($tgl_mulai!='')?$tgl_mulai:$this->input->get('tgl_mulai');
        if($tgl_mulai=='' && !(isset($_POST['tgl_mulai']) || isset($_GET['tgl_mulai']))){
            $tgl_mulai = date('d/m/Y');
        }

        $id_mesin = $this->input->post('id_mesin');
        $id_mesin = ($id_mesin!='')?$id_mesin:$this->input->get('id_mesin');

        $params = array(
            'tgl_mulai' => $tgl_mulai,
            'id_mesin' => $id_mesin
        );


        $data = $this->m_kegiatan->get($params)->result();
        $res = array();
        foreach ($data as $k) {
            $tmp = $k;
            $tmp->duration_life = round($k->duration_life/60);
            $tmp->tanggal = date('d/m/Y',strtotime($k->waktu_mulai));
            $tmp->start = date('H:i',strtotime($k->waktu_mulai));
            $end = strtotime($k->waktu_selesai);
            $tmp->end = ($end!=0)?date('H:i',$end):'-';
            $res[] = $tmp;
        }

        return $res;
    }

    function get_kegiatan(){
        $out = array(
            'data' => $this->_get_data()
        );
        echo json_encode($out);
    }

    function get_downtime(){
        $out = array(
            'data' => $this->_get_data_dt()
        );
        echo json_encode($out);
    }

    function cetak(){
        $this->load->library('template_cetak');
        $file = $this->config->item('path_tpl').'MESIN_AKTIF.xlsx';

        $data = $this->_get_data();

        if(file_exists($file)){
            $file_i = pathinfo($file);
            
            $TBS = $this->template_cetak->createNew($file_i['extension'],$file);
            $file_name = $file_i['filename'].'_'.date('dmY').'_'.date('His').'.'.$file_i['extension'];

            $TBS->MergeBlock('rec', $data);
            
            $TBS->Show(OPENTBS_DOWNLOAD, $file_name);
        } else {
            echo "File template tidak tersedia";
            exit;
        }
    }

    function cetak_downtime(){
        $this->load->library('template_cetak');
        $file = $this->config->item('path_tpl').'MESIN_DOWNTIME.xlsx';

        $data = $this->_get_data_dt();

        if(file_exists($file)){
            $file_i = pathinfo($file);
            
            $TBS = $this->template_cetak->createNew($file_i['extension'],$file);
            $file_name = $file_i['filename'].'_'.date('dmY').'_'.date('His').'.'.$file_i['extension'];

            $TBS->MergeBlock('rec', $data);
            
            $TBS->Show(OPENTBS_DOWNLOAD, $file_name);
        } else {
            echo "File template tidak tersedia";
            exit;
        }
    }
}