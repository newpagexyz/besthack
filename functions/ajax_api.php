 <?php 
	include_once('functions.php'); 
	//Функция вывода всех чатов пользователя
	function chats_by_user_id($id){
		$ret=false;
		$res=my_query('SELECT * FROM `chat_rooms` WHERE user_id='.$id.';');
		if($re=mysqli_fetch_assoc($res)){
			$array=array();
			array_push($array, $re['chat_id']);
			while($re=mysqli_fetch_assoc($res)){
				array_push($array, $re['chat_id']);
			}
			$ret=json_encode($array, JSON_UNESCAPED_UNICODE);
		}
		return $ret;
	}
	function own_chats_by_user_id($id){
		$ret=false;
		$res=my_query('SELECT * FROM `chat_owners` WHERE user_id='.$id.';');
		if($re=mysqli_fetch_assoc($res)){
			$array=array();
			array_push($array, $re['chat_id']);
			while($re=mysqli_fetch_assoc($res)){
				array_push($array, $re['chat_id']);
			}
			$ret=json_encode($array, JSON_UNESCAPED_UNICODE);
		}
		return $ret;
	}
	//Функция вывода всех пользователей чатов
	function users_id_by_chat($id){
		$ret=false;
		$res=my_query('SELECT * FROM `chat_rooms` WHERE chat_id='.$id.';');
		if($re=mysqli_fetch_assoc($res)){
			$array=array();
			array_push($array, $re['user_id']);
			while($re=mysqli_fetch_assoc($res)){
				array_push($array, $re['user_id']);
			}
			$ret=json_encode($array, JSON_UNESCAPED_UNICODE);
		}
		return $ret;
	}
	//Добавить сообщение
	function push_message($chat_id,$user_id,$text){
		$ret=false;
		if(chat_permission($chat_id,$user_id)){
			my_query('INSERT INTO chat_'.$chat_id.' SET `data`="'.$text.'", `owner_id`='.$user_id.';',array(0=>$text,1=>$chat_id));
			$ret=true;
		}
		return $ret;
	}
	//Просмтореть сообщения
	function get_messages($chat_id,$user_id,$last_id=false){
		$ret=false;
		if(chat_permission($chat_id,$user_id)){
			if($last_id!=false){
				$res=my_query('SELECT * FROM (SELECT * FROM chat_'.$chat_id.' WHERE `id`<'.$last_id.' ORDER BY id DESC LIMIT 10) t ORDER BY id;');
			}
			else{
				$res=my_query('SELECT * FROM (SELECT * FROM chat_'.$chat_id.' ORDER BY id DESC LIMIT 10) t ORDER BY id;');
			}
			if($re=mysqli_fetch_assoc($res)){
				$array=array();
				$arr=array();
				array_push($arr, $re['id']);
				array_push($arr, $re['owner_id']);
				array_push($arr, $re['date']);
				array_push($arr, $re['data']);
				array_push($array, $arr);
				while($re=mysqli_fetch_assoc($res)){
					$arr=array();
					array_push($arr, $re['id']);
					array_push($arr, $re['owner_id']);
					array_push($arr, $re['date']);
					array_push($arr, $re['data']);
					array_push($array, $arr);
				}
				$ret=json_encode($array, JSON_UNESCAPED_UNICODE);
			}
		}
		return $ret;
	}
	//Функция создания инвайт-ссылки
	function new_invite_link($chat_id,$user_id){
		global $links;
		if(check_owners($chat_id,$user_id)){
			return $links['site']."/join?key=".create_invite_link($chat_id);
		}
		else{
			return false;
		}
	}
	//Информация о пользователе
	function user_info_quick($id){
		$res=my_query('SELECT `name`,`surname`,`patronymic`,`image` from `users` WHERE `id`="'.$id.'";');
		if($re=mysqli_fetch_assoc($res)){
			return json_encode($re, JSON_UNESCAPED_UNICODE);
		}
		else{
			return false;
		}
	}
	//Вывести n публичных событий
	function last_pub_events($lim){
		$ret=false;
		$res=my_query('SELECT * from `public_events` ORDER BY id DESC LIMIT '.$lim.';');
		$arr=array();
		while($re=mysqli_fetch_assoc($res)){
			array_push($arr, $re);
		}
		if(!empty($arr)){
			$ret=json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		return $ret;
	}
	//Вывести n новостей
	function last_pub_news($lim){
		$ret=false;
		$res=my_query('SELECT * from `news` ORDER BY id DESC LIMIT '.$lim.';');
		$arr=array();
		while($re=mysqli_fetch_assoc($res)){
			array_push($arr, $re);
		}
		if(!empty($arr)){
			$ret=json_encode($arr, JSON_UNESCAPED_UNICODE);
		}
		return $ret;
	}
	//Вывести публичное событие
	function pub_event($id){
		$res=my_query('SELECT * from `public_events` WHERE `id`="'.$id.'"');
		if($re=mysqli_fetch_assoc($res)){
			return json_encode($re, JSON_UNESCAPED_UNICODE);
		}
		else{
			return false;
		}
	}
	//Вывести новость
	function pub_news($id){
		$res=my_query('SELECT * from `news` WHERE `id`="'.$id.'"');
		if($re=mysqli_fetch_assoc($res)){
			return json_encode($re, JSON_UNESCAPED_UNICODE);
		}
		else{
			return false;
		}
	}
	//Вывести приватное событие
	function priv_event($id,$user_id){
		$res=my_query('SELECT * from `private_events` WHERE `id`="'.$id.'"');
		if($re=mysqli_fetch_assoc($res)){
			if(chat_permission($re['chat_id'],$user_id)){
				return json_encode($re, JSON_UNESCAPED_UNICODE);
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	function chat_info($id,$user_id){
		if(chat_permission($id,$user_id)){
		$res=my_query('SELECT * from `chat_list` WHERE `id`="'.$id.'"');
		if($re=mysqli_fetch_assoc($res)){
				return json_encode($re, JSON_UNESCAPED_UNICODE);
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
?>
