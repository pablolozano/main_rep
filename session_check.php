<?php
  session_start();
  if(!isset($_SESSION['username']) || !isset($_SESSION['ip'])){
    header('Location: http://localhost/thesis/index.php?login=relog');
  }

?>
