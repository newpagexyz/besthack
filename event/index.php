<?php
	include_once('../functions/functions.php');
	$level=1;
	$title='Событие';
	include_once('../functions/ajax_api.php');
	if(isset($_GET['pub'])){
		include_once('../module/header.php');
		$arr=json_decode(pub_event($_GET['pub']), true);
		echo '
		 <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
            </div>
        </div>
    </section>

    <div class="is-fullheight-with-navbar" style=" background:url(verh.png)  no-repeat; padding-top: 5%;  ">
        <div class="is-fullheight-with-navbar" style=" background-image:url(niz.png); background-repeat: no-repeat; background-position: bottom right;">
            <p class="title " style="text-align: center; margin: -50px 0 0px; ">'.$arr['name'].'</p>
            <div class="hero is-small" style="padding: 0 10%;">
                <div class="hero-body" style="margin-left: 5%;">
                    <div class="slid">


                        <figure class="image is-3by1">
                            <img src="../public_image/event_img/'.$arr['img'].'">
                        </figure>

                    </div>
                    <style type="text/css">
                        .label {
                            margin-top: 5px;
                        }
                    </style>
                </div>
                <div class="container" style="text-align: center;">
                    <div class="columns is-flexible">
                        <div class="column is-size-4" style="color: #3273dc;">
                            <p>Дата начала</p><br>
                            <p>Дата окончания</p><br>
                            <p>Время начало</p><br>
                            <p>Время окончания</p><br>
                        </div>
                        <div class="column is-size-4">
                            <p>'.$arr['start_date'].'</p><br>
                            <p>'.$arr['end_date'].'</p><br>
                            <p>'.$arr['start_time'].'</p><br>
                            <p>'.$arr['end_time'].'</p><br>

                        </div>
                    </div>
                    <div class="box" style="margin: 0 10%; text-align: center;">
                        <p>'.$arr['data'].'</p>
                    </div>
                    <div class="button is-centered is-rounded " style="color: azure; background-color: #3273dc; margin-top: 50px;">Присоединиться</div>
                </div>


            </div>
        </div>
    </div>
    <div>
		';
	}
	elseif(check_cookie()){
		if(isset($_GET['priv'])){
			$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
			include_once('../module/header.php');
			$arr=json_decode(priv_event($_GET['priv'],$id),true);
			echo '
		 <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
            </div>
        </div>
    </section>

    <div class="is-fullheight-with-navbar" style=" background:url(verh.png)  no-repeat; padding-top: 5%;  ">
        <div class="is-fullheight-with-navbar" style=" background-image:url(niz.png); background-repeat: no-repeat; background-position: bottom right;">
            <p class="title " style="text-align: center; margin: -50px 0 0px; ">'.$arr['name'].'</p>
            <div class="hero is-small" style="padding: 0 10%;">
                <div class="hero-body" style="margin-left: 5%;">
                    <div class="slid">


                        <figure class="image is-3by1">
                            <img src="../public_image/event_img/'.$arr['img'].'">
                        </figure>

                    </div>
                    <style type="text/css">
                        .label {
                            margin-top: 5px;
                        }
                    </style>
                </div>
                <div class="container" style="text-align: center;">
                    <div class="columns is-flexible">
                        <div class="column is-size-4" style="color: #3273dc;">
                            <p>Дата начала</p><br>
                            <p>Дата окончания</p><br>
                            <p>Время начало</p><br>
                            <p>Время окончания</p><br>
                        </div>
                        <div class="column is-size-4">
                            <p>'.$arr['start_date'].'</p><br>
                            <p>'.$arr['end_date'].'</p><br>
                            <p>'.$arr['start_time'].'</p><br>
                            <p>'.$arr['end_time'].'</p><br>

                        </div>
                    </div>
                    <div class="box" style="margin: 0 10%; text-align: center;">
                        <p>'.$arr['data'].'</p>
                    </div>
                    <div class="button is-centered is-rounded " style="color: azure; background-color: #3273dc; margin-top: 50px;">Присоединиться</div>
                </div>


            </div>
        </div>
    </div>
    <div>
		';
		}
	}
	include_once('../module/footer.php');
?> 
