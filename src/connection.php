<?php

// dane bazy danych i servera
$servername = 'localhost';
$username = 'root';
$password = 'CodersLab';
$basename = 'Shop';

// tworzenie nowego połączenia
$conn = new mysqli($servername, $username, $password, $basename);

if($conn->connect_error){
    die("Polaczenie nieudane. Blad: " . $conn->connect_error."<br>");
}
 