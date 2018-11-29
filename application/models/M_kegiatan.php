<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_kegiatan extends CI_Model{
	public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function get($params=array()){

        if(isset($params['id_mesin'])){
            if($params['id_mesin']!=0 && $params['id_mesin']!='') {
                $this->db->where('trans_kegiatan.id_mesin',$params['id_mesin']);
            }
        }

        if(isset($params['kode_batch'])){
            $this->db->where('kode_batch',$params['kode_batch']);
        }

        if(isset($params['tgl_mulai'])){
            if($params['tgl_mulai']!=0 && $params['tgl_mulai']!='') {
                $this->db->where("DATE_FORMAT(`waktu_mulai`,'%d/%m/%Y')", $params['tgl_mulai']);
            }
        }

        if(isset($params['duration_life_is_null'])){
            $this->db->where("(duration_life = 0 OR prosentase = 0)",NULL,FALSE);
            $this->db->where('trans_kegiatan.active',0);
        }


        $this->db->join('master_product','trans_kegiatan.id_product=master_product.id_product','join');
        $this->db->join('master_mesin','trans_kegiatan.id_mesin=master_mesin.id_mesin','join');
        $this->db->order_by('waktu_mulai','desc');
        $res = $this->db->get('trans_kegiatan');
        return $res;
    }

    function get_byid($params=array()){
        if(isset($params['id_keg'])){
            $this->db->where('id_keg',$params['id_keg']);
            $this->db->join('(
                    SELECT SUM(b.downtime_duration) AS total_downtime
                    FROM trans_kegiatan a
                    LEFT JOIN trans_detailkegiatan b ON a.id_keg = b.id_keg AND STATUS = 3 AND b.waktu_mulai > a.waktu_mulai
                    AND a.id_keg = '.$params['id_keg'].'
                ) c','1=1','left');
        }
        $this->db->join('master_product','trans_kegiatan.id_product=master_product.id_product','join');
        $res = $this->db->get('trans_kegiatan')->first_row();
        return $res;
    }

    function add($params=array()){
        $res = $this->db->insert('trans_kegiatan',$params);
        return $res;
    }

    function upd($params=array()){
        if(isset($params['id_keg'])){
            $this->db->where('id_keg',$params['id_keg']);
        }
        unset($params['id_keg']);
        
        $res = $this->db->update('trans_kegiatan',$params);
        return $res;
    }
}