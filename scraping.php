<?php
ini_set('max_execution_time', 600);
    include("connection.php");
    $sql = "DELETE FROM gitar_data";
    if(mysqli_query($con,$sql)) {
    }
    include("testMelodia.php");
    include("testMelodiaAccoustic.php");
?>