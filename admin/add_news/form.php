<?php
	include_once('../../functions/ajax_api.php');
	if(check_cookie()){
	echo"<form action='' method='post' enctype='multipart/form-data'>
		<br>Изображение<input name='userfile' type='file' required>
		<br>Название события<input name='event_name' type='text' required>
		<br>Дата начала<input type='date' id='start_date' name='start_date' required>
		<br>Время начала<input type='text' id='start_time' name='start_time' maxlength=5 minlength=5 placeholder='01:21' required>
		<br>Дата конца<input type='date' id='end_date' name='end_date' required>
		<br>Время конца<input type='text' id='end_time' name='end_time' maxlength=5 minlength=5 placeholder='23:49' required>
		<br><textarea name='data'></textarea>
		TEMA<select name=subject>";
		$sub=get_subjects();
		foreach($sub as $value=>$text){
		  echo"<option value='".$value."'>".$text."</option>";
		}
		echo"</select>
		<input type='submit'>
	";
	}else{
		echo"sorry";
	}
?>
