<?php

    function updateUsers(){
        $idConn = mysqli_connect('localhost','root','');
        $bd = mysqli_select_db($idConn,'tesis');
        $query = 'SELECT username, UNIX_TIMESTAMP(fecha) as time FROM login_session WHERE status = "ON"';
        $res = mysqli_query($idConn,$query);
        $result_arr = mysqli_fetch_array($res);
        foreach($result_arr as $ra){
            if((time() - $ra['time']) > 1440 ){
                $update = 'UPDATE login_session SET status = "OFF" WHERE username = "'.$ra['username'].'"';
                $res = mysqli_query($idConn,$query);
                $result_arr = mysqli_fetch_array($res);
            }
        }
    }

?>
