<?php
	$title='Создание чата';
	$level=1;
	include_once('../functions/functions.php');
	if(check_cookie()){
		if(!empty($_FILES)&isset($_POST['chat_name'])){
			if($re=upload_chat_logo()){
				$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
				if($c=create_chat($_POST['chat_name'],$re,$id)){
					header('Location: ../chat?id='.$c);
				}
			}
			else{
				include_once('../module/header.php');
				echo"<script>alert('Недопустимый формат файла, импользуйте JPEG, PNG, GIF');</script>";
				include_once('form.php');
			}
		}
		else{
			include_once('../module/header.php');
			include_once('form.php');
		}
	}
	else{
		create_refer('add_chat');
		header('Location: ../auth');
	}
	include_once('../module/footer.php');
?> 
