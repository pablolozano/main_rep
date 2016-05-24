<?php

session_start();
if(isset($_SESSION['username'])){
  if(isset($_POST['usermsg'])){
    $text = $_POST['usermsg'];

    $fp = fopen("../log.html", 'a');
    fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['username']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    fclose($fp);
  }
}


?>
