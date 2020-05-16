<?php
	include_once('config.php');
	//Функция для безопасных SQL запросов, первый аргумент - текст запроса в бд, второй - массив из экранируемых строк
	function my_query($q, $for_safe=array()){
		global $mysql;
		$link = mysqli_connect($mysql['host'], $mysql['user'], $mysql['password'], $mysql['dbname']);
		if(!empty($for_safe)){
			foreach($for_safe as $text){
				mysqli_real_escape_string($link,$text);
			}
		}
		$res=false;
		if($link){
			$res=mysqli_query($link,$q);
			mysqli_close($link);
		}
		return $res;
	}
	//Функция регистрации пользователя,вводить имя, фамилию, email, пароль
	function reg_user($name,$surname,$patronymic,$study,$work,$birth,$sex,$email,$password){
		if(check_mail($email)){
			my_query('INSERT INTO `users` set `value`=1, `name`="'.$name.'", `surname`="'.$surname.'", `email`="'.$email.'",`password`="'. hash('sha256',$password).'", `patronymic`="'.$patronymic.'",`study`="'.$study.'",`work`="'.$work.'",`sex`="'.$sex.'",`birth`="'.$birth.'";',array(0=>$email,1=>$password,2=>$name,3=>$surname,4=>$patronymic,5=>$study,6=>$work,7=>$sex,8=>$birth));
			$res=my_query('SELECT `id` from `users` WHERE `email`="'.$email.'";',array(0=>$email));
			$res=mysqli_fetch_assoc($res);
			create_confirmation_link($res['id'],$email);
			return true;
		}
		else{
			return false;
		}
	}
	//Функция проверки свободности имейла
	function check_mail($email){
		$res=my_query('SELECT * FROM `users` WHERE email="'.$email.'";',array(0=>$email));
		if(mysqli_fetch_assoc($res)){
			return false;
		}
		else{
			return true;
		}
	}
	//Сгененрировать строку в 64 символа
	function gen_token() {//Генератор токенов
		$token =  hash('sha256',microtime() . 'salt' . time());
		return $token;
	}
	//Функция авторизации, вводится email и пароль
	function auth($email,$password){
		$ret=false;
		$res=my_query('SELECT * FROM `users` WHERE `email`="'.$email.'" AND `password`="'. hash('sha256',$password).'";',array(0=>$email,1=>$password));
			if($result=mysqli_fetch_assoc($res)){
				if((int)$result['value']>1){
					$session=gen_token();
					$token=gen_token();
					create_web_session($session,$token,$result['id']);
					$ret=true;
				}
				else{
					$ret="NV";
				}
			}
		return $ret;
	}
	//Функция проверки доступа к чату
	function chat_permission($chat_id,$user_id){
		$ret=false;
		$res=my_query('SELECT user_id FROM `chat_rooms` WHERE chat_id="'.$chat_id.'" AND user_id="'.$user_id.'";',array(0=>$chat_id,0=>$user_id));
		if(mysqli_fetch_assoc($res)){
			$ret=true;
		}
		return $ret;
	}
	//Выдать информацию о чате
	function get_chat_info($chat_id){
		$ret=false;
		$res=my_query('SELECT * FROM `chat_list` WHERE id="'.$chat_id.'";',array(0=>$chat_id));
		if($re=mysqli_fetch_assoc($res)){
			$array=array();
			array_push($array, $re['name']);
			array_push($array, $re['logo']);
			$ret=$array;
		}
		return $ret;
	}
	//Функция, создющая куки и пишет в бд
	function create_web_session($session,$token,$id){
		$res=my_query('INSERT INTO `connections` SET session="'.$session.'", token="'.$token.'",user_id="'.$id.'";',array(0=>$session,1=>$token));
		create_st_cookie($session,$token);
	}
	//Функция для проверки валидности сессии в браузере
	function check_cookie(){
		$ret=false;
		if(isset($_COOKIE['session']) AND isset($_COOKIE['token'])){
			$session=$_COOKIE['session'];
			$token=$_COOKIE['token'];
			$res=my_query('SELECT * FROM `connections` WHERE session="'.$session.'" AND token="'.$token.'";',array(0=>$session,1=>$token));
			if($res=mysqli_fetch_assoc($res)){
				$ret=true;
				//change_cookie($_COOKIE['session'],$_COOKIE['token']);
			}
		}
		return $ret;
	}
	//Функция для изменения токена
	function change_cookie($session,$token){
		$token=gen_token();
		$res=my_query('UPDATE `connections` SET token="'.$token.'"  WHERE session="'.$session.'";',array(0=>$session,1=>$token));
		create_st_cookie($session,$token);
	}
	//Создать сессию+токен в коках
	function create_st_cookie($session,$token){
		setcookie("session", $session, time()+3600000, "/");
		setcookie("token", $token, time()+3600000, "/");
	}
	//Получить id по сессии
	function get_id_by_session($session,$token){
		$res=my_query('SELECT * FROM `connections` WHERE session="'.$session.'";',array(0=>$session,1=>$token));
		if($r=mysqli_fetch_assoc($res)){
			return $r['user_id'];
		}
	}
	//Функция отправки подтверждения регистрации
	function create_confirmation_link($id,$email){
		global $links;
		$token =gen_token();
		my_query('INSERT INTO `confirmations` SET `user_id`='.$id.', token="'.$token.'";');
	 	/*file_put_contents('/var/www/besthack/file.txt',smtp_send($email,'Подтверждение регистрации', '
		Здравствуйте.
		Создан аккаунт:
		Логин: '.$email.'
		Пожалуйста, перейдите по ссылке ниже для завершения регистрации в личном кабинете.
		<a href="'.$links['site'].'/confirm?t='.$token.'">'.$links['site'].'/confirm?t='.$token.'</a> 
		'));*/
		smtp_send($email,'Подтверждение регистрации', '
		Здравствуйте.
		Создан аккаунт:
		Логин: '.$email.'
		Пожалуйста, перейдите по ссылке ниже для завершения регистрации в личном кабинете.
		<a href="'.$links['site'].'/confirm?t='.$token.'">'.$links['site'].'/confirm?t='.$token.'</a> 
		');
	}
	//Переход на рефер ссылку
	function goto_refer_cookie(){
		global $links;
		$ref='Location: '.$links['site'];
		if(isset($_COOKIE["refer"])){
			$ref='Location: ../'.$_COOKIE["refer"];
			unset($_COOKIE['refer']);
			setcookie('refer', null, -1, '/');
		}
		header($ref);
		exit();
	}
	//Функция создания рефера
	function create_refer($place){
		setcookie("refer", $place, time()+3600000, "/");
	}
	//Функция деавторизации юзера
	function deauth(){
		if(isset($_COOKIE['sesion'])){
			unset($_COOKIE['session']);
			setcookie('session', null, -1, '/');
		}
		if(isset($_COOKIE['token'])){
			unset($_COOKIE['token']);
			setcookie('token', null, -1, '/');
		}
		header('Location: ../');
	}
	//Функция для возврата имени по кукам
	function ret_name_by_cookie(){
		$ret=false;
		if(isset($_COOKIE['session']) AND isset($_COOKIE['token'])){
			$session=$_COOKIE['session'];
			$token=$_COOKIE['token'];
			$res=my_query('SELECT * FROM `connections` WHERE session="'.$session.'";',array(0=>$session,1=>$token));
			if($res=mysqli_fetch_assoc($res)){
				$res=my_query('SELECT * FROM `users` WHERE id="'.$res['user_id'].'";');
				if($res=mysqli_fetch_assoc($res)){
					$ret=$res['name'];
				}
			}
		}
		return $ret;
	}
	//Функция для возврата имени по id
	function ret_name_by_id($id){
		$ret=false;
		$res=my_query('SELECT * FROM `users` WHERE id="'.$id.'";');
		if($res=mysqli_fetch_assoc($res)){
			$ret=$res['name'];
		}
		return $ret;
	}
	//Смена статуса после ссылки подтверждения 
	function confirmer($token){
		$ret=false;
		$res=my_query('SELECT `user_id` FROM `confirmations` WHERE token="'.$token.'";');
		if($r=mysqli_fetch_assoc($res)){
			$res=my_query('UPDATE `users` SET value= 2 WHERE `id` = '.$r['user_id'].';');
			my_query('DELETE FROM `confirmations` WHERE token="'.$token.'";');
			$ret=true;
		}
		return $ret;
	}
	//Функция отправки почты, указать отправителя, тему, текст письма
	function smtp_send($to,$subject,$body){
		global $mail_config;
		require_once "SendMailSmtpClass.php"; // Сторонний код для smtp
		$mailSMTP = new SendMailSmtpClass($mail_config['smtp_username'], $mail_config['smtp_password'], $mail_config['smtp_host'], $mail_config['sender_name'], $mail_config['smtp_port']);
		// заголовок письма
		$headers= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
		$headers .= "From: besthack<".$mail_config['sender_name'].">\r\n"; // от кого письмо
		$result =  $mailSMTP->send($to, $subject, $body, $headers); // отправляем письмо
		return $result;
	}
	//Функция, для добавления в чат по ссылке
	function add_chat_by_link($t){
		$ret=false;
		if($chat_id=check_chat_by_link($t)){
			$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
			my_query('INSERT INTO `chat_rooms` SET  `user_id`='.$id.', chat_id='.$chat_id.';');
			$ret=true;
		}
		return $ret;
	}
	//Функция, для добавления нахожения id чата по ссылке
	function check_chat_by_link($link){
		$ret=false;
		$res=my_query('SELECT * FROM `chat_confirm` WHERE token="'.$link.'";');
		if($res=mysqli_fetch_assoc($res)){
			$ret=$res['chat_id'];
		}
		return $ret;
	}
	//Функция добавления чата
	function create_chat($name,$logo,$owner_id){
		$ret=false;
		my_query('INSERT INTO `chat_list` set `name`="'.$name.'", `logo`="'.$logo.'";',array(0=>$name));
		$res=my_query('SELECT `id` from `chat_list` WHERE `name`="'.$name.'" AND `logo`="'.$logo.'";',array(0=>$name));
		if($r=mysqli_fetch_assoc($res)){
			add_chat_owner($r['id'],$owner_id);
			add_chat_user($r['id'],$owner_id);
			create_messages_table($r['id']);
			$ret=$r['id'];
		}
		return $ret;
	}
	function create_messages_table($id){
		my_query('CREATE TABLE chat_'.$id.'
		LIKE chat_example
		;');
	}
	function add_chat_owner($chat_id,$user_id){
		my_query('INSERT INTO `chat_owners` set `chat_id`='.$chat_id.', `user_id`='.$user_id.';');
	}
	function add_chat_user($chat_id,$user_id){
		my_query('INSERT INTO `chat_rooms` set `chat_id`='.$chat_id.', `user_id`='.$user_id.';');
	}
	//Функция, создающая инфайт-ссылку
	function create_invite_link($chat_id){
		$token =gen_token();
		my_query('INSERT INTO `chat_confirm` SET `chat_id`='.$chat_id.', token="'.$token.'";');
		return $token ;
	}
	function check_owners($chat_id,$user_id){
		$ret=false;
		$res=my_query('SELECT user_id FROM `chat_owners` WHERE chat_id="'.$chat_id.'" AND user_id="'.$user_id.'";',array(0=>$chat_id,0=>$user_id));
		if(mysqli_fetch_assoc($res)){
			$ret=true;
		}
		return $ret;
	}
	//Загрузка изображения на сервер, вставить $_FILES
	function upload_chat_logo(){
		return upload_img('../public_image/chats_logo/');
	}
	//Загрузить аватарку пользователя
	function upload_user_av($id){
		if($re=upload_img('../public_image/user_av/')){
			my_query('UPDATE `users` SET `image`="'. $re.'" WHERE `id`="'.$id.'";',array(0=>$id));
			return true;
		}
		else{
			return false;
		}
	}
	//Загрузка картинки
	function upload_img($uploaddir){
		global $_FILES;
		$ret=false;
		$user_file_name=$_FILES['userfile']['name'];
		$type=false;
		if(substr($user_file_name,strlen($_FILES['userfile']['name'])-4)==".gif"){
			$type=".gif";
		}
		elseif(substr($user_file_name,strlen($_FILES['userfile']['name'])-4)==".jpg"){
			$type=".jpg";
		}
		elseif(substr($user_file_name,strlen($_FILES['userfile']['name'])-5)==".jpeg"){
			$type=".jpeg";
		}
		elseif(substr($user_file_name,strlen($_FILES['userfile']['name'])-4)==".bmp"){
			$type=".bmp";
		}
		elseif(substr($user_file_name,strlen($_FILES['userfile']['name'])-4)==".png"){
			$type=".png";
		}
		if($type){
			$filename=gen_token().$type;
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir.$filename)) {
				$ret=$filename;
			}
		}
		return $ret;
	}
	function upload_event_img(){
		return upload_img('../public_image/event_img/');
	}
	function upload_news_img(){
		return upload_img('../../public_image/news/');
	}
	//Функция дропа пользователя из чата
	function drop_user($chat_id,$user_id){
		$res=my_query('DELETE FROM `chat_rooms` WHERE chat_id="'.$chat_id.'" AND user_id="'.$user_id.'";');
		return true;
	}
	//Вывести права пользователя
	function power_by_id($id){
		$res=my_query('SELECT * FROM `users` WHERE `id`="'.$id.'";',array(0=>$id));
			if($result=mysqli_fetch_assoc($res)){
				return (int)$result['value'];
			}
			else{
				return false;
			}
	}
	//Добавить приватный чат
	function create_privat_event($user_id,$chat_id,$event_name,$subject,$start_date,$start_time,$end_date,$end_time,$data,$img){
		$ret=false;
		if(check_owners($chat_id,$user_id)){
			my_query('INSERT INTO `private_events` SET `data`="'.$data.'", `owner_id`="'.$user_id.'",`subject`="'.$subject.'",`name`="'.$event_name.'",`img`="'.$img.'",`start_date`="'.$start_date.'",`end_date`="'.$end_date.'",`end_time`="'.$user_id.'",`start_time`="'.$start_time.'", `chat_id`="'.$chat_id.'";',array(0=>$user_id,1=>$chat_id,2=>$event_name,3=>$subject,4=>$start_date,5=>$start_time,6=>$end_date,7=>$end_time,8=>$data));
			$res=my_query('SELECT `id` FROM `private_events` WHERE `owner_id`="'.$user_id.'"  AND  `subject`="'.$subject.'" AND `name`="'.$event_name.'" AND `img`="'.$img.'" AND `start_date`="'.$start_date.'" AND `end_date`="'.$end_date.'" AND `end_time`="'.$user_id.'" AND `start_time`="'.$start_time.'" AND  `chat_id`="'.$chat_id.'" ORDER BY id DESC;',array(0=>$user_id,1=>$chat_id,2=>$event_name,3=>$subject,4=>$start_date,5=>$start_time,6=>$end_date,7=>$end_time));
			if($r=mysqli_fetch_assoc($res)){
				$ret=$r['id'];
			}	
		}
		return $ret;
	}
	//Публичные мероприятия
	function create_public_event($user_id,$event_name,$subject,$start_date,$start_time,$end_date,$end_time,$data,$img){
		$ret=false;
		if(power_by_id($user_id)>2){
			my_query('INSERT INTO `public_events` SET `data`="'.$data.'", `owner_id`="'.$user_id.'",`subject`="'.$subject.'",`name`="'.$event_name.'",`img`="'.$img.'",`start_date`="'.$start_date.'",`end_date`="'.$end_date.'",`end_time`="'.$user_id.'",`start_time`="'.$start_time.'";',array(0=>$user_id,1=>$event_name,2=>$subject,3=>$start_date,4=>$start_time,5=>$end_date,6=>$end_time,7=>$data));
			$res=my_query('SELECT `id` FROM `public_events` WHERE `owner_id`="'.$user_id.'"  AND  `subject`="'.$subject.'" AND `name`="'.$event_name.'" AND `img`="'.$img.'" AND `start_date`="'.$start_date.'" AND `end_date`="'.$end_date.'" AND `end_time`="'.$user_id.'" AND `start_time`="'.$start_time.'" ORDER BY id DESC;',array(0=>$user_id,1=>$event_name,2=>$subject,3=>$start_date,4=>$start_time,5=>$end_date,6=>$end_time));
			if($r=mysqli_fetch_assoc($res)){
				$ret=$r['id'];
			}	
		}
		return $ret;
	}
	//Новость
	function create_news($user_id,$event_name,$subject,$start_date,$start_time,$end_date,$end_time,$data,$img){
		$ret=false;
		if(power_by_id($user_id)>9){
			my_query('INSERT INTO `news` SET `data`="'.$data.'", `owner_id`="'.$user_id.'",`subject`="'.$subject.'",`name`="'.$event_name.'",`img`="'.$img.'",`start_date`="'.$start_date.'",`end_date`="'.$end_date.'",`end_time`="'.$user_id.'",`start_time`="'.$start_time.'";',array(0=>$user_id,1=>$event_name,2=>$subject,3=>$start_date,4=>$start_time,5=>$end_date,6=>$end_time,7=>$data));
			$res=my_query('SELECT `id` FROM `news` WHERE `owner_id`="'.$user_id.'"  AND  `subject`="'.$subject.'" AND `name`="'.$event_name.'" AND `img`="'.$img.'" AND `start_date`="'.$start_date.'" AND `end_date`="'.$end_date.'" AND `end_time`="'.$user_id.'" AND `start_time`="'.$start_time.'" ORDER BY id DESC;',array(0=>$user_id,1=>$event_name,2=>$subject,3=>$start_date,4=>$start_time,5=>$end_date,6=>$end_time));
			if($r=mysqli_fetch_assoc($res)){
				$ret=$r['id'];
			}	
		}
		return $ret;
	}
	//Вывод тем
	function get_subjects(){
		$res=my_query('SELECT * from `subjects`');
		$arr=array();
		while($re=mysqli_fetch_assoc($res)){
			$arr[$re['id']]=$re['text'];
		}
		return $arr;
	}
	//Добавить тему
	function add_subject($text){
		my_query('INSERT INTO `subjects` SET text="'.$text.'";',array(0=>$text));
	}
	//Удалить тему
	function drop_subject($id){
		my_query('DELETE FROM `subjects` WHERE id='.$id.';',array(0=>$id));
	}
	//Бан пользователя
	function change_value($id,$val){
		$res=my_query('UPDATE `users` SET value= '.$val.' WHERE `id` = '.$id.';',array(0=>$id,1=>$val));
	}
	//Список верификаций админом
	function verifications_list(){
		$res=my_query('SELECT * from `verification_queries`  ORDER BY id DESC LIMIT 100');
		$arr=array();
		while($re=mysqli_fetch_assoc($res)){
			array_push($arr,$re['owner_id']);
		}
		return $arr;
	}
	//Стереть попытку верификации админом
	function delete_verif($id){
		$res=my_query('DELETE from `verification_queries`  WHERE `owner_id`='.$id.';',array(0=>$id));
	}
	//Занести попытку верификации
	function add_verif_list($id){
		$res=my_query('INSERT INTO `verification_queries`  SET `owner_id`='.$id.';',array(0=>$id));
	}
	//Вывести всю информацию о пользователе
	function full_user_info($id){
		$res=my_query('SELECT * from `users` WHERE `id`="'.$id.'";',array(0=>$id));
		if($re=mysqli_fetch_assoc($res)){
			return $re;
		}
		else{
			return false;
		}
	}
	//Смена пароля
	function update_password($id,$old,$new){
		$ret=false;
		$res=my_query('SELECT * FROM `users` WHERE `id`="'.$id.'" AND `password`="'. hash('sha256',$old).'";',array(0=>$id));
			if($result=mysqli_fetch_assoc($res)){
				my_query('UPDATE `users` SET `password`="'. hash('sha256',$new).'" WHERE id`="'.$id.'" AND `password`="'. hash('sha256',$old).'";',array(0=>$id));
				$ret=true;
			}
		return $ret;
	}
	function link_events($id,$pub){
		$res=my_query('INSERT INTO `pub_connect`  SET `user_id=`'.$id.' `pub_event_id`='.$pub.';',array(0=>$id));
	}
	function update_bio($id,$bio){
		my_query('UPDATE `users` SET `bio`="'. $bio.'" WHERE `id`="'.$id.'";',array(0=>$id,1=>$bio));
	}
?>
