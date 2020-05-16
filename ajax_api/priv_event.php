<?php
	include_once('../functions/ajax_api.php');
	if(check_cookie()){
		if(isset($_GET['priv'])){
			$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
			echo priv_event($_GET['priv'],$id);
		}
	}
?> 
