<?php
	include_once('../functions/functions.php');
	if(isset($_GET['t'])){
		confirmer($_GET['t']);
	}
	echo "<script>window.location.href='../';</script>
	<a href='../auth'>Если редирект не произошёл, нажмите здесь</a>
	";
?>
