<?php
    $servername = "localhost";
    $database = "going_news";
    $username = "root";
    $password = "";

    //berfungsi mengkonekan
    $conn = mysqli_connect($servername, $username, $password, $database);

    //cek apakah sudah terhubung dengan database atau belum
    if(!$conn){
        die("Koneksi gagal: " . mysql_connect_error());
    }
?>