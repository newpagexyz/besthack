<?php
	$title='Создание события';
	$level=1;
	$no_glider=true;
	include_once('../functions/functions.php');
	if(check_cookie()){
		//echo"<script>alert('".print_r($_POST)."');</script>";
		if(!empty($_FILES) AND isset($_POST['event_name']) AND isset($_POST['start_date'])AND isset($_POST['start_time'])AND isset($_POST['end_date'])AND isset($_POST['end_time'])AND isset($_POST['data'])AND isset($_POST['subject'])){
			if($re=upload_event_img()){
				$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
				if(isset($_POST['chat_id'])){
					if($_POST['chat_id']!='none'){
							if($c=create_privat_event($id,$_POST['chat_id'],$_POST['event_name'],$_POST['subject'],$_POST['start_date'],$_POST['start_time'],$_POST['end_date'],$_POST['end_time'],$_POST['data'],$re)){
								header('Location: ../event?priv='.$c);
							}
							else{
								include_once('../module/header.php');
								echo"seomething went wrong o_0";	
							}
					}
					else{
						$c=create_public_event($id,$_POST['event_name'],$_POST['subject'],$_POST['start_date'],$_POST['start_time'],$_POST['end_date'],$_POST['end_time'],$_POST['data'],$re);
						header('Location: ../event?pub='.$c);
					}
				}
				else{
					$c=create_public_event($id,$_POST['event_name'],$_POST['subject'],$_POST['start_date'],$_POST['start_time'],$_POST['end_date'],$_POST['end_time'],$_POST['data'],$re);
					header('Location: ../event?pub='.$c);
				}	
			}
			else{
				echo"Недопустимый формат файла, импользуйте JPEG, PNG, GIF";
				include_once('../module/header.php');
				include_once('form.php');
			}
		}
		else{
			include_once('../module/header.php');
			include_once('form.php');
		}
	}
	else{
		create_refer('add_eventst');
		header('Location: ../auth');
	}
	include_once('../module/footer.php');
?> 
