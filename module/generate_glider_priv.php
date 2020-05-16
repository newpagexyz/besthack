
<?php
	if(!isset($url)){
		$url='../';
	}
	include_once($url.'functions/ajax_api.php');
	$re=json_decode(last_pub_news(5), true);
	//echo(last_pub_news(5));
	foreach($re as $value){
		echo '<div class="hero is-fullheight-with-navbar">';
		echo '<figure class="image is-3by1">
					<img src="/public_image/news/'.$value['img'].'"style="padding-left: 20%; padding-right: 20%"></figure>';
		echo'<a href="/news?pub='.$value['img'].'"<button class="button is-link is-rounded " style="margin: 2vw 0 -2vw; position: relative;left: 50%;transform: translate(-50%, 0); width:10vw;">Подробнее</button></a>';
		echo '<div class="hero-body" style="text-align: center; left: 300px; top: -50px">
				'.$value['data'].'
				</div>
                    </div>';
	}
?>                
