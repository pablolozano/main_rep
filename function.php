<?php

include('db.php');

function getClientIp(){
	if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)){
		$IParray=array_values(array_filter(explode(',',$_SERVER['HTTP_X_FORWARDED_FOR'])));
		return end($IParray);
	}else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
		return $_SERVER["REMOTE_ADDR"];
	}else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
		return $_SERVER["HTTP_CLIENT_IP"];
	}
	return '';
}

function saveIp($type,$usr,$ip){
	$db = new DB('root', '', 'tesis');
	switch($type){
		case 'notFound':
			if(!$byPassIpLog){
				$db->query('INSERT INTO login_status values(NULL,"'.$usr.'","'.$ip.'","'.date("Y-m-d H:i:s").'","Not Found")');
			}
			break;
		case 'wrongPass':
			if(!$byPassIpLog){
				$db->query('INSERT INTO login_status values(NULL,"'.$usr.'","'.$ip.'","'.date("Y-m-d H:i:s").'","Wrong Password")');
			}
			break;
		case 'goodPass':
			$db->query('DELETE FROM login_status where username = "'.$usr.'"');
			break;
	}
}

function updateUsers(){
    $db = new DB('root', '', 'tesis');
    $result_arr = $db->query('SELECT username, UNIX_TIMESTAMP(fecha) as time FROM login_session WHERE status = "ON"');
    foreach($result_arr as $ra){
        if((time() - $ra['time']) > 1440 ){
            $db->query('UPDATE login_session SET status = "OFF" WHERE username = "'.$ra['username'].'"');
        }
    }
    return $db->query('SELECT username FROM login_session WHERE status = "ON"');
}

function updateCurrentUser($usrN,$type){
	$db = new DB('root', '', 'tesis');
    $db->query('UPDATE login_session SET status = "'.$type.'"  WHERE username = "'.$usrN.'"');
}

function hosturi(){
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	return $host.$uri;
}

function moveTo($page){
	header("Location: http://".hosturi()."/".$page);
}




?>
