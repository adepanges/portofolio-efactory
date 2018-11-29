<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Log extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
		
    }

    function index(){
        $this->root_check_access('login_page');

    	$this->load->view('main-inc/login');
    }

    function in(){

        $params = array(
            'username' => trim($this->input->post('username')),
            'password' => md5(trim($this->input->post('password')))
        );

        $this->load->model('m_log');
        $res = $this->m_log->cek_log($params);
        if($res->num_rows()>0){
            $user = $res->first_row();

            $params2 = array(
                'id_user' => $user->id_user
            );
            $res_machine = $this->m_log->cek_active_machine($params2);
            
            $id_mesin = 0;
            $id_keg = 0;
            $kode_session = 0;
            if($res_machine->num_rows()>0){
                $m = $res_machine->first_row();
                $id_mesin = $m->id_mesin;
                $id_keg = $m->id_keg;
                $kode_session = $m->kode_session;
            }

            $data = array(
                'is_login' => true,
                'id_user' => $user->id_user,
                'id_mesin' => $id_mesin,
                'id_keg' => $id_keg,
                'kode_session' => $kode_session,
                'username' => $user->username,
                'password' => $user->password,
                'nama' => $user->nama,
                'usergroupid' => $user->id_hakakses,
                'usergroup' => $user->nama_hakakses
            );

            $this->session->set_userdata($data);
            redirect();
        } else {
            redirect('log');
        }
    }

    function out(){
		$this->session->sess_destroy();
		redirect($this->config->item('log_in_link'));
    }
}