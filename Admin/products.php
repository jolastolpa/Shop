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
        
             <?php include __DIR__ . '/nav.php' ?>
    </head>
    <body> 
       
        <div class="col-lg-12 text-center  "> <br><br><br>
            <div class="list-group"> <br><br>
                <h3>
            <a href="addProduct.php" class="list-group-item">Dodaj produkt  <span class="glyphicon glyphicon-plus "></span></a> 
            
            <a href="searchProducts.php" class="list-group-item">Wyszukaj by edytować lub usunąć <span class="glyphicon glyphicon-search "></span></a>
           
                </h3>
          </div>
        </div>