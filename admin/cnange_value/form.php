<?php
	include_once('../../functions/ajax_api.php');
	echo"<form action='' method='post'>
		<br>id<input name='id' type='text' required>
		<select name='value'>
		<option value=0>
		Забанен
		</option>
		<option value=2>
		Рядовой пользователь
		</option>
		<option value=3>
		Верифицированный пользователь
		</option>
		<option value=10>
		Модератор
		</option>
		<option value=11>
		Администратор
		</option>
		</select>
		<input type='submit'>
	";	
?>
