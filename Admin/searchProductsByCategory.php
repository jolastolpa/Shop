<?php
 
require_once __DIR__.'/require_once.php'; 


if (!isset($_SESSION['logged'])) {
    header('Location:log.php');
    exit();
} 
?> 


<!DOCTYPE html>
<html>
    <head>
        <title> Szukaj po kategorii</title>
        <?php include __DIR__ . '/nav.php' ?><br><br><br><br>
    </head>
    <body> 
        <ol class="breadcrumb">
           <li><a href="index.php">Home</a></li>
           <li><a href="products.php">Zarządzanie produktem</a></li> 
           <li><a href="searchProducts.php">Wyszukaj</a></li>
           <li class="active">Wyszukaj po kategorii </li>
        </ol><br><br><br> 
        
   
        <div class="col-md-8 text-left panel panel-success "> 
           
        
        </div> 
        
        <div class="col-md-8 text-left ">  
            <?php 
            ?> 
        </div>


