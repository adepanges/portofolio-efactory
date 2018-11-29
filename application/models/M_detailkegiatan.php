<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_detailkegiatan extends CI_Model{
	public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function get($params=array()){
        $this->db->select('trans_detailkegiatan.*, trans_kegiatan.kode_batch, master_mesin.nama_mesin, master_mesin.kode_mesin, master_problem.*');

        if(isset($params['id_keg'])){
            $this->db->where('trans_detailkegiatan.id_keg',$params['id_keg']);
        }

        if(isset($params['status'])){
            $this->db->where('trans_detailkegiatan.status',$params['status']);
        }

        if(isset($params['id_mesin'])){
            if($params['id_mesin']!=0 && $params['id_mesin']!='') {
                $this->db->where('trans_kegiatan.id_mesin',$params['id_mesin']);
            }
        }

        if(isset($params['tgl_mulai'])){
            if($params['tgl_mulai']!=0 && $params['tgl_mulai']!='') {
                $this->db->where("DATE_FORMAT(trans_detailkegiatan.waktu_mulai,'%d/%m/%Y')", $params['tgl_mulai']);
            }
        }

        if(isset($params['downtime_duration'])){
            if($params['downtime_duration']=='IS_NULL'){
                $this->db->where('trans_detailkegiatan.downtime_duration IS NULL');
            } else if($params['downtime_duration']=='IS_NOT_NULL'){
                $this->db->where('trans_detailkegiatan.downtime_duration IS NOT NULL');
            }
        }

        $this->db->from('trans_detailkegiatan');
        $this->db->join('trans_kegiatan','trans_detailkegiatan.id_keg=trans_kegiatan.id_keg','left');
        $this->db->join('master_mesin','trans_kegiatan.id_mesin=master_mesin.id_mesin','left');
        $this->db->join('master_problem','trans_detailkegiatan.id_problem=master_problem.id_problem and master_problem.status = 1','left');
        $this->db->order_by('trans_kegiatan.id_keg','asc');
        $this->db->order_by('trans_kegiatan.waktu_mulai','asc');
        $res = $this->db->get();
        return $res;
    }

    function get_byid($params=array()){
        if(isset($params['id_detailkegiatan'])){
            $this->db->where('id_detailkegiatan',$params['id_detailkegiatan']);
        }
        if(isset($params['id_keg'])){
            $this->db->where('id_keg',$params['id_keg']);
        }
        if(isset($params['status'])){
            $this->db->where('trans_detailkegiatan.status',$params['status']);
            if($params['status']){
                $this->db->order_by("trans_detailkegiatan.waktu_mulai", "desc");
            }
        }
        $this->db->join('master_problem','trans_detailkegiatan.id_problem=master_problem.id_problem and master_problem.status=1','left');
        $res = $this->db->get('trans_detailkegiatan')->first_row();
        return $res;
    }

    function add($params=array()){
        $res = $this->db->insert('trans_detailkegiatan',$params);
        return $res;
    }

    function upd($params=array()){
        if(isset($params['id_detailkegiatan'])){
            $this->db->where('id_detailkegiatan',$params['id_detailkegiatan']);
        }
        unset($params['id_detailkegiatan']);
        
        $res = $this->db->update('trans_detailkegiatan',$params);
        return $res;
    }
}