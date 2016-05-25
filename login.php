<html>
  <head>
<?php
require('function.php');
if(isset($_POST['entrar'])){
  $idConn = mysqli_connect('localhost','root','');
  $byPassIpLog = false;
  $username = mysql_real_escape_string($_POST['username']);
  $password = mysql_real_escape_string($_POST['password']);
  $ipAdd = getClientIp();
  if(!$idConn){
      die("Error! No se pudo realizar la conexion con la base de datos.");
  }
  else{
    $bd = mysqli_select_db($idConn,'tesis');
    $query = 'SELECT UNIX_TIMESTAMP(fecha) as time FROM login_status WHERE ipAdd = "'.$ipAdd.'" ORDER BY UNIX_TIMESTAMP(fecha) DESC LIMIT 10';
    $res = mysqli_query($idConn,$query);
    $rs = mysqli_fetch_array($res);
    print_r($rs.'second');
  	if($rs){
  		if((time() - $rs['time']) > 600){
  			header('Location: http://localhost/thesis/home.php?login=wait'. (600 - (time() - $resultado['time'])));
  		}
  	}
  	$query = 'SELECT * FROM usuarios WHERE username = "'.$username.'"';
  	$res = mysqli_query($idConn,$query);
    $rs = mysqli_fetch_array($res);
  	echo $query;
  	if(!$rs){
  	  /*---TRIGGERALARMS---*/
  	  //saveIp('notFound',$username,$ipAdd);
      $query = 'INSERT INTO login_status values(NULL,"'.$username.'","'.$ipAdd.'","'.date("Y-m-d H:i:s").'","Not Found")';
      mysqli_query($idConn,$query);
  	  header('Location: http://localhost/thesis/index.php?login=noUser');
  	}else{
  	  if($rs['password'] != $password){
    		/*---TRIGGERALARMS---*/
    		$query = 'SELECT count(*) as total FROM login_status WHERE username = "'.$username.'" ORDER BY UNIX_TIMESTAMP(fecha) DESC LIMIT 10';
        $res = mysqli_query($idConn,$query);
        $rs = mysqli_fetch_array($res);
    		if($rs['total'] < 5){
    		  //saveIp('wrongPass',$username,$ipAdd);
          if(!$byPassIpLog){
    				$query = 'INSERT INTO login_status values(NULL,"'.$username.'","'.$ipAdd.'","'.date("Y-m-d H:i:s").'","Wrong Password")';
    				mysqli_query($idConn,$query);
    			}
    		  header('Location: http://localhost/thesis/index.php?login=wrongPass');
    		}else{
    		  /*saveIp('wrongPass',$username,$ipAdd);
          if(!$byPassIpLog){
    				$query = 'INSERT INTO login_status values(NULL,"'.$usr.'","'.$ip.'","'.date("Y-m-d H:i:s").'","Wrong Password")';
    				mysqli_query($idConn,$query);
    			}*/
    		  header('Location: http://localhost/thesis/index.php?login=blocked');
    		}
  	  }else{
    		/*---success check like ip and stuff---*/
    		//saveIp('goodPass',$username,$ipAdd);
        $query = 'DELETE FROM login_status where username = "'.$username.'"';
  		mysqli_query($idConn,$query);
    		session_start();
    		$_SESSION['username'] = $username;
    		$_SESSION['ip'] = $ipAdd;
                updateCurrentUser($username);
    		header('Location: http://localhost/thesis/home.php');
  	  }
  	}
  }
}
?>
  </head>
  <body>
  </body>
</html>
