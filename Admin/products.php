<?php
session_start();  
require_once __DIR__.'/../config.php'; 
require_once __DIR__.'/../src/Product.php'; 
require_once __DIR__.'/../src/index.html'; 

?> 

<!DOCTYPE html>
<html>
    <head>
        <title> Zarządzanie produktami</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css" type="text/css" />
    </head>
    <body>
        <div class="col-lg-12 text-center "> <br><br><br>
            <ul class="list-group">
                <h2><li class="list-group-item"> <a href="addProduct.php">Dodaj nowy produkt</a> </li><h2>
                <h2><li class="list-group-item"> <a href="addProduct">Dodaj nowy produkt</a> </li><h2>
                <h2><li class="list-group-item"> <a href="addProduct">Dodaj nowy produkt</a> </li> <h2>
            </ul>
        </div>