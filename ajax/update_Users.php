<?php

require('../db.php');
$db = new DB('root', '', 'tesis');
$result_arr = $db->select('SELECT a.estatus, UNIX_TIMESTAMP(log_time) as time FROM usuarios as a, login_session as b WHERE a.username = b.username');
if($result_arr){
    foreach ($result_arr as $ra) {
        if($ra['estatus'] == 2){
            if(time() - $ra['time'] < 120){
                echo 'logout';
				return;
            }
        }
    }
}
$result_arr = $db->select('SELECT username, UNIX_TIMESTAMP(log_time) as time FROM login_session WHERE status = "ON"');
if(!$result_arr){
	echo 'No connected users';
	return;
}
foreach($result_arr as $ra){
	if((time() - $ra['time']) > 120 ){
		$db->query('UPDATE login_session SET status = "OFF" WHERE username = "'.$ra['username'].'"');
	}
}
$result = $db->select('SELECT username, ipAdd FROM login_session WHERE status = "ON"');
foreach($result as $res){
    echo $res['username']." ".$res['ipAdd'].'-';
}


?>
