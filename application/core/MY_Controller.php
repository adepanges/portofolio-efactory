<?php

class MY_Controller extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	}

	function check_access($usergroupid=0){
		// usergroupid can access this task

		if (strpos($usergroupid, ((string) $this->session->userdata('usergroupid'))) === FALSE) {
			redirect($this->config->item('log_out_link'));
		}
	}

	function root_check_access($page=''){
		$is_login = $this->session->userdata('is_login');
		$usergroupid = $this->session->userdata('usergroupid');

		if($is_login){
			switch ($usergroupid) {
				case $this->config->item('usergroupid_administrator'):
					redirect($this->config->item('access_root_administrator'));
					break;
				
				case $this->config->item('usergroupid_supervisor'):
					redirect($this->config->item('access_root_supervisor'));
					break;

				case $this->config->item('usergroupid_operator'):
					redirect($this->config->item('access_root_operator'));
					break;

				default:
					redirect($this->config->item('log_out_link'));
					break;
			}
		} else if($page!='login_page'){
			redirect($this->config->item('log_in_link'));
		}
	}
}