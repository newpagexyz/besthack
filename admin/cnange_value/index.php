<?php
	include_once('../../functions/functions.php');
	if(check_cookie()){
		$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
		if(power_by_id($id)>10){
			echo "Hello,".ret_name_by_cookie().". If you want to exit, press <a href='../../logout'>here</a>";
			if(isset($_POST['id'])&isset($_POST['value'])){
				change_value($_POST['id'],$_POST['value']);
			}
			else{
				include_once('form.php');
			}
		}
		else{
			header('Location: ../../404.html');
		}
	}
	else{
		create_refer('admin');
		header('Location: ../../auth');
	}
?> 
