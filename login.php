<?php
include('function.php');
$db = new DB('root', '', 'tesis');
if(isset($_POST['entrar'])){
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['password']);
	$ipAdd = getClientIp();
	$rs = $db->select('SELECT * FROM usuarios WHERE username = "'.$username.'"');
	$estatus = $rs[0]['estatus'];
	$dbPass = $rs[0]['password'];
	$pass_time = $rs[0]['pass_time'];
	$normalIP = $res[0]['normalIP'];
	if(!$rs){
		  /*---TRIGGERALARMS---*/
		$db->query('INSERT INTO login_status values(NULL,"'.$username.'","'.$ipAdd.'","'.date("Y-m-d H:i:s").'","Not Found")');
		moveTo('index.php?login=noUser');
	}else{
		if($dbPass != $password){
			/*---TRIGGERALARMS---*/
			$res = $db->select('SELECT count(*) as total, UNIX_TIMESTAMP(fecha) as time FROM login_status WHERE username = "'.$username.'" ORDER BY UNIX_TIMESTAMP(fecha) DESC LIMIT 10');
			if($res){
				if($res[0]['total'] < 5){
				  $db->query('INSERT INTO login_status values(NULL,"'.$username.'","'.$ipAdd.'","'.date("Y-m-d H:i:s").'","Wrong Password")');
				  moveTo('index.php?login=wrongPass');
				}else{
				  if((time() - $res[0]['time']) < 120){
					moveTo('index.php?login=blocked');
				  }else{
				    moveTo('index.php?login=wrongPass');
				  }
				}
			}else{
				$db->query('INSERT INTO login_status values(NULL,"'.$username.'","'.$ipAdd.'","'.date("Y-m-d H:i:s").'","Wrong Password")');
				moveTo('index.php?login=wrongPass');
			}
		}else{
            if($estatus == 2){
                moveTo('index.php?login=b');
            }
			if($pass_time == NULL || $estatus != 0){
				$db->query('UPDATE `usuarios` SET `pass_time`="'.date("Y-m-d H:i:s").'" where username = "'.$username.'"');
			}
			/*---success check like ip and stuff---*/
			$db->query('DELETE FROM login_status where username = "'.$username.'"');
			$res = $db->select('SELECT * from login_session WHERE username = "'.$username.'"');
			if(!$res){
				$db->query('INSERT INTO login_session (username,status,ipAdd) values("'.$username.'","ON","'.$ipAdd.'")');
			}else{
				updateCurrentUser($username,'ON',$ipAdd);
			}
			$res = $db->select('SELECT normalIP from usuarios WHERE username = "'.$username.'"');
            if($res[0]['normalIP'] == NULL){
				$db->query('UPDATE usuarios SET normalIP = "'.$ipAdd.'" WHERE username = "'.$username.'"');
			}
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['ip'] = $ipAdd;
			moveTo('home.php');
		}
	}
}
?>
