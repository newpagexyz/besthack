<?php
	include_once('../functions/functions.php');
	if(check_cookie()){
		$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
		if(power_by_id($id)>9){
			echo "Hello,".ret_name_by_cookie().". If you want to exit, press <a href='../logout'>here</a>";
			echo"<br><a href='add_news'>Добавить новость</a>";
			echo"<br><a href='add_subject'>Добавить темы</a>";
			echo"<br><a href='verif'>Верификация пользователей</a>";
			if(power_by_id($id)>9){echo"<br><a href='cnange_value'>Смена прав</a>";}
			echo"<br><a href='ban'>Панель бана</a>";
		}
		else{
			create_refer('add_chat');
			header('Location: ../404.html');
		}
	}
	else{
		create_refer('add_chat');
		header('Location: ../auth');
	}
?> 
