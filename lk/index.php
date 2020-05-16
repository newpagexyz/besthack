<?php
	include_once('../functions/functions.php');
	$level=1;
	$title='Лк';
	if(check_cookie()){
		$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
		if(isset($_POST['password']) AND isset($_POST['old_password'])){
			if(update_password($id,$_POST['old_password'],$_POST['password'])){
				echo"<script>alert('Password changed');</script>";
			}
			else{
				echo"<script>alert('Incorrect password')</script>";
			}
		}
		if(isset($_POST['bio'])){
			update_bio($id,$_POST['bio']);
		}
		if(isset($_POST['name']) AND isset($_POST['surname'])){
			if(isset($_POST['patronymic'])){
				$patronymic=$_POST['patronymic'];
			}
			else{
				$patronymic=false;
			}
			if(isset($_POST['study'])){
				$study=$_POST['study'];
			}
			else{
				$study=false;
			}
			if(isset($_POST['work'])){
				$work=$_POST['work'];
			}
			else{
				$work=false;
			}
			if(update_user($id,$_POST['name'],$_POST['surname'],$patronymic,$study,$work)){
				echo"<script>alert('Данные обновлены')</script>";
			}
			else{
				echo"<script>alert('Что-то пошло не так')</script>";
			}
		}
		if(!empty($_FILES)){
			if($re=upload_user_av($id)){
				echo"<script>alert('Succesfullu changeg')</script>";
			}
			else{
				echo"<script>alert('Something went wrong')</script>";
			}
		}
		$arr=full_user_info($id);
		include_once('../module/header.php');
		include_once('form.php');
		echo"<a href='../try_verif'>";
	}
	else{
		create_refer('lk');
		header('Location: ../auth');
	}
	include_once('../module/footer.php');
?> 
