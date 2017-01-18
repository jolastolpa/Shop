<?php
session_start();  
require_once __DIR__.'/../config.php'; 
require_once __DIR__.'/../src/Product.php'; 
require_once __DIR__.'/../src/index.html'; 

?> 

<!DOCTYPE html>
<html>
    <head>
        <title> Szukaj</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css" type="text/css" /> 
        
             <?php include __DIR__ . '/nav.php' ?>
    </head>
    <body>  
        <ol class="breadcrumb">
           <li><a href="index.php">Home</a></li>
           <li><a href="products.php">Zarządzanie produktem</a></li>
           <li class="active">Wyszukaj</li>
        </ol><br> 
             <?php if (isset($_SESSION['delete'])){ 
                   echo $_SESSION['delete']; 
                   unset( $_SESSION['delete']);
             } ?>
       
        <div class="col-lg-12 text-center  "> <br><br><br>
            <div class="list-group"> <br><br>
                <h3>
            <a href="searchProductsByName.php" class="list-group-item">Szukaj po nazwie  </a> 
            <a href="searchProductsByCategory.php" class="list-group-item">Szukaj po kategorii  </a>
            <a href="searchProductsByPrice.php" class="list-group-item">Szukaj po cenie</a>
            <a href="searchProductsByQuantity.php" class="list-group-item">Szukaj po ilość  </a>
                </h3>
          </div>
        </div>

