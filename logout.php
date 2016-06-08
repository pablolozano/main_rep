<?php
    require('function.php');
    session_start();
    updateCurrentUser($_SESSION['username'],'OFF');
    session_destroy();
    moveTo('index.php');

?>
