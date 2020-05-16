<?php
	include_once('../functions/ajax_api.php');
	if(check_cookie()){
		if(isset($_GET['chat'])){
			$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
			if(chat_permission($_GET['chat'],$id)){
				if($ans=users_id_by_chat($_GET['chat'])){
					echo $ans;
				}
				else{
					echo "No users";
				}
			}
			else{
				echo "No chat access";
			}
		}
		else{
			echo "No chat selected";
		}
	}
	else{
		echo "auth failed";
	}
?> 
