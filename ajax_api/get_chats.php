<?php
	include_once('../functions/ajax_api.php');
	if(check_cookie()){
		$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
		if($ans=chats_by_user_id($id)){
			echo $ans;
		}
		else{
			echo"No chats";
		}
	}
	else{
		echo "auth failed";
	}
?> 
