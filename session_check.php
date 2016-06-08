<?php
    session_start();
    if(!isset($_SESSION['username']) || !isset($_SESSION['ip'])){
        moveTo('index.php?login=relog');
    }
	checkPass($_SESSION['username']);
	
?>
