<?php
    require('function.php');
    session_start();
    if(isset($_SESSION['username']) || isset($_SESSION['ip'])){
        updateCurrentUser($_SESSION['username'],'OFF',$_SESSION['ip']);
    }
    session_destroy();
    moveTo('index.php');

?>
