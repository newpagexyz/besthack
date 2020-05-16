//Функция дял ajax-get запросов, вводится адрес и функция для возврата(необязательно);
function ajax(url,fun=false){
	 var xmlhttp = new XMLHttpRequest();
	var func=fun;
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
           if (xmlhttp.status == 200) {
			   if(func!=undefined&func!=false){
				func(xmlhttp.responseText);
			   }
			   else{
				console.log(xmlhttp.responseText);
			   }
           }
           else {
			    if(func!=undefined&func!=false){
					func(xmlhttp.status + ': ' + xmlhttp.statusText);
				}
			   else{
				console.log(xmlhttp.status + ': ' + xmlhttp.statusText);
			   }
           }
        }
    };

    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}
//Функция запроса чатов пользователя (авторизация через cookie)
function get_chats(fun){
		ajax("../ajax_api/get_chats.php",fun);
}
function get_users(c,fun){
	ajax("../ajax_api/get_users.php?chat="+c,fun);
}
function push_message(c, text,fun){
	ajax("../ajax_api/push_message.php?chat="+c+"&data="+text,fun);
}
function get_messages(c,fun,last=false){
	if(last){
		ajax("../ajax_api/get_messages.php?chat="+c+"&last="+last,fun);
	}
	else{
		ajax("../ajax_api/get_messages.php?chat="+c,fun);
	}
}
function new_invite_link(c,fun){
	ajax("../ajax_api/new_invite_link.php?chat="+c,fun);
}
function drop_user(c,uid,fun){
	ajax("../ajax_api/drop_user.php?chat="+c+"&uid="+uid,fun);
}
function user_info_quick(uid,fun){
	ajax("../ajax_api/user_info_quick.php?uid="+uid,fun);
}
function chat_info(chat,fun){
	ajax("../ajax_api/chat_info.php?chat="+chat,fun);
}
