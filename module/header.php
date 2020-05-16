<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $title; ?></title>
		<?php
		
			if(!isset($level)){
				$lev=1;
			}
			else{
				$lev=$level;
			}
			$url="";
			while($lev>0){
				$lev=$lev-1;
				$url=$url."../";;
			}
			include_once($url.'functions/functions.php');
		?> 
		
		<link rel='stylesheet' type='text/css' href='<?php echo $url; ?>style/header.css'>
		<link rel='stylesheet' type='text/css' href='<?php echo $url; ?>style/index.css'>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.2/css/bulma.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>style/glider.css">
		<script src="<?php echo $url; ?>js/glider.js"></script>
	</head>
	
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Get all "navbar-burger" elements
        const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

        // Check if there are any navbar burgers
        if ($navbarBurgers.length > 0) {

            // Add a click event on each of them
            $navbarBurgers.forEach(el => {
                el.addEventListener('click', () => {

                    // Get the target from the "data-target" attribute
                    const target = el.dataset.target;
                    const $target = document.getElementById(target);

                    // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                    el.classList.toggle('is-active');
                    $target.classList.toggle('is-active');

                });
            });
        }

    });
</script>

<body class="has-navbar-fixed-top">
    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="besthack.newpage.xyz">
                <img src="https://static.tildacdn.com/tild6466-6365-4164-b137-336431383231/noroot.png" width="128" height="128">
            </a>

            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link is-arrowless is-arrowless">
                    Мероприятия
                </a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item">
                        Мероприятия раз
                    </a>
                        <a class="navbar-item">
                        Мероприятия два
                    </a>
                        <a class="navbar-item">
                        Мероприятия три
                    </a>
                    </div>
                </div>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link is-arrowless">
                    Участникам
                </a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item" href="<?php echo $url; ?>/add_chat">
							Созать чат
                    </a>
                        <a class="navbar-item" href="<?php echo $url; ?>/chat">
							Мои чаты
                    </a>
                        <a class="navbar-item" href="<?php echo $url; ?>/add_events">
							Создать мероприятие
                    </a>
                    </div>
                </div>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link is-arrowless">
                    Партнерам
                </a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item">
                        Партнерам раз
                    </a>
                        <a class="navbar-item">
                        два
                    </a>
                        <a class="navbar-item">
                        три
                    </a>
                    </div>
                </div>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link is-arrowless">
                    О нас
                </a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item">
                        О нас раз
                    </a>
                        <a class="navbar-item">
                        О нас два
                    </a>
                        <a class="navbar-item">
                        О нас три
                    </a>
                    </div>
                </div>
                <a class="navbar-item">
                Контакты
            </a>
            </div>

            <div class="navbar-end ">
                <a class="navbar-item" href='<?php echo $url;?>lk'>
                Личный кабинет
                 </a>

                <div class="navbar-item   has-dropdown is-hoverable">
                    <a class="navbar-link is-arrowless">
                        <figure class="image is-64x64">
                           <?php
                        if(isset($_COOKIE['session'])&isset($_COOKIE['token'])){
							if(check_cookie()){
								$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
								$arr=full_user_info($id);
								if($arr['image']!=null or $arr['image']!=false){
									echo'<img src="'.$url.'/public_image/user_av/'.$arr['image'].'" class="is-rounded">';
								}
								else{
									echo'<img src="'.$url.'/public_image/default/no_img.png" class="is-rounded">';
								}
							}
							else{
								echo'<img src="'.$url.'/public_image/default/no_img.png" class="is-rounded">';
							}
						}
						else{
							echo'<img src="'.$url.'/public_image/default/no_img.png" class="is-rounded">';
						}
					?>
                    </figure>
                    </a>

                    <div class="navbar-dropdown is-right">
                        <a class="navbar-item" href='<?php echo $url;?>lk'>
                        Мой профиль
                    </a>
                        <a class="navbar-item">
                        Мои сообщения
                    </a>
                        <a class="navbar-item">
                        Мои мероприятия
                    </a>
                    </div>
                </div>



            </div>
        </div>
        </div>
    </nav>
					

