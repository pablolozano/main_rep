<?php

    require('../db.php');

    function getClientIp2(){
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

    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['ip'])){
        $username = $_SESSION['username'];
        $ipAdd = getClientIp2();
        if($ipAdd == ''){
            $ipAdd = $_SESSION['ip'];
        }
        $db = new DB('root', '', 'tesis');
        $rs = $db->select('SELECT normalIP, estatus, UNIX_TIMESTAMP(pass_time) as time FROM usuarios WHERE username = "'.$username.'"');
		$time = $rs[0]['time'];
        if($ipAdd != $rs[0]['normalIP']){
    		$db->query('UPDATE usuarios SET estatus = 2 WHERE username = "'.$username.'"');
            $fp = fopen("log.html", 'w');
            fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>SERVER</b>: CHAT BORRADO <br></div>");
            fclose($fp);
            echo 'logout';
			return;
    	}
        if($rs[0]['estatus'] == 2){
            echo 'logout.php?s=breach';
			return;
        }elseif($rs[0]['estatus'] == 1){
        		if($time == NULL){
        			echo 'newPass';					
					return;
        		}
        		if((time() - $time) > 120){
        			echo 'newPass';
					return;
        		}
        }
        $db->query('UPDATE login_session SET status = "ON", ipAdd = "'.$ipAdd.'"  WHERE username = "'.$username.'"');
        echo time();
    }






 ?>
