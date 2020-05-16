<?php
	include_once('../functions/functions.php');
	if(check_cookie()){
		$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
		if(power_by_id($id)==2){
			add_verif_list($id);
			echo"Added";
			header('Location: ../lk');
		}
		else{
			header('Location: ../lk');
		}
	}
	else{
		header('Location: ../lk');
	}
?> 
