<?php
    session_start();
    if(!isset($_SESSION['username']) || !isset($_SESSION['ip'])){
        moveTo('index.php?login=relog');
    }
	checkIp($_SESSION['username']);
	checkPass($_SESSION['username']);

?>
