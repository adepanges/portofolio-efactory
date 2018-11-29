<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class App extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->check_access(1);
        $this->load->model('m_mesin');
        $this->load->model('m_problem');
        $this->load->model('m_user');
    }

    function index(){
    		$data['app'] = array(
	    		'SITE_URL'=>site_url(),
	    		'BASE_URL'=>base_url(),
	    		'FACTORY_URL'=>base_url().'views/efactory',
	    	);
		$this->load->view('main_extjs',$data);
    }
}