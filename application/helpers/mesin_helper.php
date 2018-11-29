<?php

	function bg_warna($id=0){
		$id = islogin_mesin((int) $id);

		switch ($id) {
			case 1:
				$out = 'bg-gray';
				break;

			case 2:
				$out = 'bg-green';
				break;

			case 3:
				$out = 'bg-red';
				break;

			case 4:
				$out = 'bg-yellow';
				break;
			
			default:
				$out = '';
				break;
		}
		return $out;
	}

	function status_mesin($id=0){
		$id = islogin_mesin((int) $id);
		switch ($id) {
			case 1:
				$out = 'Stopped';
				break;

			case 2:
				$out = 'Running';
				break;

			case 3:
				$out = 'Down Time';
				break;

			case 4:
				$out = 'Down Time is Confirm';
				break;
			
			default:
				$out = '';
				break;
		}
		return $out;
	}

	function islogin_mesin($id){
		$ci =& get_instance();

		$is_login = $ci->session->userdata('is_login');

		if($is_login){
			$out = $id;
		} else if($id!=1){
			$out = 2;
		} else {
			$out = 1;
		}
		return $out;
	}