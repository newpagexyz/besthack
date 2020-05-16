<?php
	include_once('../functions/ajax_api.php');
	if(check_cookie()){
		if(isset($_GET['data']) AND isset($_GET['chat'])){
			$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
			echo push_message($_GET['chat'],$id,$_GET['data']);
		}
		else{
			echo "No chat selected";	
		}
	}
	else{
		echo"auth failed";
	}
?> 
