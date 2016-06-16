<?php
session_start();
include('function.php');
$db = new DB('root', '', 'tesis');
if(isset($_POST['cambiar'])){
	$username = $_SESSION['username'];
	$ipAdd = $_SESSION['ip'];
	$oldPass = mysql_real_escape_string($_POST['oldPass']);
	$nuPass1 = mysql_real_escape_string($_POST['nuPass1']);
	$nuPass2 = mysql_real_escape_string($_POST['nuPass2']);
	if($nuPass1 == $nuPass2){
		if($nuPass1 != $oldPass){
			$rs = $db->select('SELECT * FROM usuarios WHERE username = "'.$username.'"');
			if(!$rs){
				  /*---TRIGGERALARMS---*/
				$db->query('INSERT INTO login_status values(NULL,"'.$username.'","'.$ipAdd.'","'.date("Y-m-d H:i:s").'","Fatal Not Found")');
				$session_destroy();
				moveTo('index.php?login=noUser');
			}else{
				if($rs[0]['password'] != $oldPass){
					/*---TRIGGERALARMS---*/
					$res = $db->select('SELECT count(*) as total FROM login_status WHERE username = "'.$username.'" ORDER BY UNIX_TIMESTAMP(fecha) DESC LIMIT 10');
					if($res){
						if($res[0]['total'] < 5){
						  $db->query('INSERT INTO login_status values(NULL,"'.$username.'","'.$ipAdd.'","'.date("Y-m-d H:i:s").'","Wrong Password")');
						  moveTo('new_pass.php?login=wrongPass');
						}else{
						  session_destroy();
						  moveTo('index.php?login=blocked');
						}
					}else{
						$db->query('INSERT INTO login_status values(NULL,"'.$username.'","'.$ipAdd.'","'.date("Y-m-d H:i:s").'","Wrong Password")');
						moveTo('new_pass.php?login=wrongPass');
					}
				}else{
					if($rs[0]['time'] == NULL && $rs[0]['estatus'] != 0){
						$db->query('UPDATE `usuarios` SET password = "'.$nuPass1.'", `pass_time`="'.date("Y-m-d H:i:s").'" where username = "'.$username.'"');
					}
					/*---success check like ip and stuff---*/
					$db->query('DELETE FROM login_status where username = "'.$username.'"');
					$res = $db->select('SELECT * from login_session WHERE username = "'.$username.'"');
					moveTo('home.php');
				}
			}	
		}else{
			moveTo('new_pass.php?login=noUser2');			
		}
	}else{
		moveTo('new_pass.php?login=noUser');
	}
}
?>