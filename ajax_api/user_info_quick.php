<?php
	include_once('../functions/ajax_api.php');
	if(check_cookie()){
		if(isset($_GET['uid'])){
			echo user_info_quick($_GET['uid']);
		}
		else{
			echo "No uid";
		}
	}
	else{
		echo "auth failed";
	}
?> 
