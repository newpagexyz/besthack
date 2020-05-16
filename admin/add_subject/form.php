<?php
	include_once('../../functions/ajax_api.php');
	echo"<form action='' method='post'>
		<br>Тема<input name='subject' type='text' required>
		<input type='submit'>
	";
		$sub=get_subjects();
		echo"Удалить тему:";
		foreach($sub as $value=>$text){
		  echo"<br><a href=?drop=".$value.">".$text."</a>";
		}
		
?>
