<?php
	include_once('../../functions/ajax_api.php');
		$ver=verifications_list();
		echo"Ожидают:";
		foreach($ver as $value=>$text){
		  echo"<br>".$text."  ".ret_name_by_id($id)."<a href=?add=".$text.">Подтвердить</a>";
		  echo"|<a href=?drop=".$text.">Отклонить</a>";
		}
		
?>
