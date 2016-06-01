<?php

require('../db.php');
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
$result = $db->select('SELECT username FROM login_session WHERE status = "ON"');
foreach($result as $res){
	echo $res['username'].'-';
}


?>