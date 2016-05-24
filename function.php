<?php

/*function checkBypass(){
	$byPassIpLog = false;
}*/

$byPassIpLog = false;
$idConn = mysqli_connect('localhost','root','');
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

function query($qStr){
	$result = mysqli_query($idConn,$qStr);
	return  mysqli_fetch_array($result);
}

function saveIp($type,$usr,$ip){
	switch($type){
		case 'notFound':
			if(!$byPassIpLog){
				$query = 'INSERT INTO login_status values(NULL,"'.$usr.'","'.$ip.'","'.date("Y-m-d H:i:s").'","Not Found")';
				mysqli_query($idConn,$query);
			}
			break;
		case 'wrongPass':
			if(!$byPassIpLog){
				$query = 'INSERT INTO login_status values(NULL,"'.$usr.'","'.$ip.'","'.date("Y-m-d H:i:s").'","Wrong Password")';
				mysqli_query($idConn,$query);
			}
			break;
		case 'goodPass':
			$query = 'DELETE FROM login_status where username = "'.$usr.'"';
			mysqli_query($idConn,$query);
			break;
	}
}


?>
