<?php
	include_once('../functions/ajax_api.php');
	if(check_cookie()){
		if(isset($_GET['chat'])){
			$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
			echo new_invite_link($_GET['chat'],$id);
		}
		else{
			echo "No chat selected";
		}
	}
	else{
		echo "auth failed";
	}
?> 
