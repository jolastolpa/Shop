<?php

session_start();  
require_once __DIR__.'/../config.php'; 
require_once __DIR__.'/../src/Product.php'; 
require_once __DIR__.'/../src/Image.php';  
require_once __DIR__.'/../src/Admin.php'; 
require_once __DIR__.'/../src/Category.php'; 
require_once __DIR__.'/../src/index.html'; 

if (!isset($_SESSION['logged'])) {
    header('Location:log.php');
    exit();
} 
?> 


<!DOCTYPE html>
<html>
    <head>
        <title> Dodaj produkt</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css" type="text/css" /> 
        <?php include __DIR__ . '/nav.php' ?><br><br><br><br>
    </head>
    <body> 
        <ol class="breadcrumb">
           <li><a href="index.php">Home</a></li>
           <li><a href="products.php">Zarządzanie produktem</a></li>
           <li class="active">Wszystkie produkty</li>
        </ol><br><br><br> 
        
        <div class="col-sm-8 text-left  ">  
            <h3>Wszystkie produkty dostępne w sklepie:<h3> 
             <?php Product::loadAllProducts($conn) ;

