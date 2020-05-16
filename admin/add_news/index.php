<?php
	include_once('../../functions/functions.php');
	if(check_cookie()){
		$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
		if(power_by_id($id)>9){
			echo "Hello,".ret_name_by_cookie().". If you want to exit, press <a href='../../logout'>here</a>";
			if(!empty($_FILES) AND isset($_POST['event_name']) AND isset($_POST['start_date'])AND isset($_POST['start_time'])AND isset($_POST['end_date'])AND isset($_POST['end_time'])AND isset($_POST['data'])AND isset($_POST['subject'])){
				if($re=upload_news_img()){
					$c=create_news($id,$_POST['event_name'],$_POST['subject'],$_POST['start_date'],$_POST['start_time'],$_POST['end_date'],$_POST['end_time'],$_POST['data'],$re);
					header('Location: ../../news?pub='.$c);
				}
				else{
					echo"Недопустимый формат файла, импользуйте JPEG, PNG, GIF";
					include_once('form.php');
				}
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
