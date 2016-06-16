<?php
$dir    = '../syslog/172.16.0.1';
$files2 = scandir($dir, 1);
$handle = fopen('../syslog/172.16.0.1/'.$files2[0], "r");
while(!feof($handle)){
    foreach((array)fgetcsv($handle) as $f){
        echo $f;
    }
    echo '</br>';
}
fclose($handle);
?>
