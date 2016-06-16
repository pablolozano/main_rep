<?php
    require('function.php');
    session_start();
    if(isset($_SESSION['username']) || isset($_SESSION['ip'])){
        updateCurrentUser($_SESSION['username'],'OFF',$_SESSION['ip']);
    }
	if(isset($_GET['s'])){
		if($_GET['s'] == 'breach'){
			session_destroy();
			moveTo('index.php?login=b');			
		}
	}
    session_destroy();
    moveTo('index.php');

?>
