<html>
  <head>
<?php
include('function.php');
$db = new DB('root', '', 'tesis');
if(isset($_POST['entrar'])){
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['password']);
	$ipAdd = getClientIp();
	/*$rs = $db->query('SELECT UNIX_TIMESTAMP(fecha) as time, ipAdd FROM login_status WHERE ipAdd = "'.$ipAdd.'" ORDER BY UNIX_TIMESTAMP(fecha) DESC LIMIT 10');
	print_r($rs);
	if($rs){
		if((time() - $rs[0]->time) > 600){
			moveTo('home.php?login=wait'. (600 - (time() - $rs['time'])));
		}
	}*/
	$rs = $db->query('SELECT * FROM usuarios WHERE username = "'.$username.'"');
	if(!$rs){
		  /*---TRIGGERALARMS---*/
		$db->query('INSERT INTO login_status values(NULL,"'.$username.'","'.$ipAdd.'","'.date("Y-m-d H:i:s").'","Not Found")');
		moveTo('index.php?login=noUser');
	}else{
		if($rs[0]->password != $password){
			/*---TRIGGERALARMS---*/
			$db->query('SELECT count(*) as total FROM login_status WHERE username = "'.$username.'" ORDER BY UNIX_TIMESTAMP(fecha) DESC LIMIT 10');
			if($rs){
				if($rs['total'] < 5){
				  $db->query('INSERT INTO login_status values(NULL,"'.$username.'","'.$ipAdd.'","'.date("Y-m-d H:i:s").'","Wrong Password")');
				  moveTo('index.php?login=wrongPass');
				}else{
				  moveTo('index.php?login=blocked');
				}
			}else{
				$db->query('INSERT INTO login_status values(NULL,"'.$username.'","'.$ipAdd.'","'.date("Y-m-d H:i:s").'","Wrong Password")');
				moveTo('index.php?login=wrongPass');
			}
		}else{
			/*---success check like ip and stuff---*/
			$db->query('DELETE FROM login_status where username = "'.$username.'"');
			$res = $db->query('SELECT * from login_session WHERE username = "'.$username.'"');
			if(!$res){
				$db->query('INSERT INTO login_session (username,status,ipAdd) values("'.$username.'","ON","'.$ipAdd.'")');
			}else{
				updateCurrentUser($username,'ON');
			}
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['ip'] = $ipAdd;
			moveTo('home.php');
		}
	}	
}
?>
  </head>
</html>
