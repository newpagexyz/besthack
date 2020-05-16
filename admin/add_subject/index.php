<?php
	include_once('../../functions/functions.php');
	if(check_cookie()){
		$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
		if(power_by_id($id)>9){
			echo "Hello,".ret_name_by_cookie().". If you want to exit, press <a href='../../logout'>here</a>";
			if(isset($_GET['drop'])){
				drop_subject($_GET['drop']);
			}
			if(isset($_POST['subject'])){
				add_subject($_POST['subject']);
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
