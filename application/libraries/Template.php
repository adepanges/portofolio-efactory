<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Template {
	
	function __construct(){
		$this->_ci = &get_instance();
	}
	
	function display($view,$data=NULL){
	
		if(!isset($data['title'])) $data['title'] = NULL;


		$data['_header'] = $this->_ci->load->view('main-inc/header',$data,TRUE);
		
		if(is_array($view)){
			$data['_content'] = array();
			foreach ($view as $t){
				array_push($data['_content'],$this->_ci->load->view($t,$data,TRUE));
			}
		} else {
			if($view !== '') $data['_content'] = $this->_ci->load->view($view,$data,TRUE);
			else $data['_content'] = "";
		}
		$data['_footer'] = $this->_ci->load->view('main-inc/footer',$data,TRUE);
		$this->_ci->load->view('template',$data,FALSE);
	}
}