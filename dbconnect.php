<?php
    $hostname = "localhost";
    $user = "root";
    $pass = "";
    $db = "monkeyai";

    $connect = mysqli_connect($hostname, $user, $pass, $db) OR DIE ("Connection failed");
?>