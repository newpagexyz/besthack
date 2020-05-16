<?php
	include_once('../functions/ajax_api.php');
	if(check_cookie()){
		if(isset($_GET['chat'])AND isset($_GET['uid'])){
			$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
			if(check_owners($_GET['chat'],$id)){
				if($ans=drop_user($_GET['chat'],$_GET['uid'])){
					echo $ans;
				}
				else{
					echo "Can's do that, sorry =(";
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
