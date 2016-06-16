<?php

require('db.php');

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

/*function saveIp($type,$usr,$ip){
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
}*/

/*function updateUsers(){
    $db = new DB('root', '', 'tesis');
    $result_arr = $db->select('SELECT username, UNIX_TIMESTAMP(log_time) as time FROM login_session WHERE status = "ON"');
	if(!$result_arr){
		return false;
	}
    foreach($result_arr as $ra){
        if((time() - $ra['time']) > 1440 ){
            $db->query('UPDATE login_session SET status = "OFF" WHERE username = "'.$ra['username'].'"');
        }
    }
    return $db->select('SELECT username FROM login_session WHERE status = "ON"');
}*/

function updateCurrentUser($usrN,$type,$ip = false){
	$db = new DB('root', '', 'tesis');
	/*$rs = $db->select('SELECT estatus FROM usuarios WHERE username = "'.$usrN.'"');
    if($rs[0]['estatus'] == 2){
        moveTo('logout.php');
    }*/
    if(!$ip){
        $db->query('UPDATE login_session SET status = "'.$type.'", ipAdd = "'.$ip.'"  WHERE username = "'.$usrN.'"');
    }else{
        $db->query('UPDATE login_session SET status = "'.$type.'"  WHERE username = "'.$usrN.'"');
    }
}

function hosturi(){
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	return $host.$uri;
}

function moveTo($page){
	header("Location: http://".hosturi()."/".$page);
}

function checkPass($usr){
	$db = new DB('root', '', 'tesis');
	$rs = $db->select('SELECT estatus, UNIX_TIMESTAMP(pass_time) as time FROM usuarios WHERE username = "'.$usr.'"');
	$time = $rs[0]['time'];
	$estatus = $rs[0]['estatus'];
	if($estatus == 1){
		if($time == NULL){
			moveTo('new_pass.php');
		}
		if((time() - $time) > 120){
			moveTo('new_pass.php');
		}
	}
}

function checkIp($usr){
    $db = new DB('root', '', 'tesis');
	$rs = $db->select('SELECT normalIP, estatus FROM usuarios WHERE username = "'.$usr.'"');
	$ip = getClientIp();
	if($ip != $rs[0]['normalIP']){
		$db->query('UPDATE usuarios SET estatus = 2 WHERE username = "'.$usr.'"');
        $fp = fopen("log.html", 'w');
        fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>SERVER</b>: CHAT BORRADO <br></div>");
        fclose($fp);
        moveTo('logout.php?s=breach');
	}
	if($rs[0]['estatus'] == 2){
		updateCurrentUser($_SESSION['username'],'OFF',$_SESSION['ip']);
		session_destroy();
		moveTo('index.php?login=b');
	}
}



?>
