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
        <title> Edytuj/usuwaj</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css" type="text/css" /> 
        <?php include __DIR__ . '/nav.php' ?><br><br><br><br>
    </head>
    <body> 
        <ol class="breadcrumb">
           <li><a href="index.php">Home</a></li>
           <li><a href="products.php">Zarządzanie produktem</a></li>
           <li class="active">Wyszukaj by edytować</li>
        </ol><br><br><br> 
        
   
        <div class="col-sm-8 text-left panel panel-success "> 
           
            <form role="form" method="POST" action="#"> 
                
                <div class="form-group"><br>
                     <label for="name">Nazwa przedmiotu</label>
                     <input type="text" class="form-control"  id="name" name="name" 
                </div> <br>
                 <input class="btn btn-toolbar" type="submit" value="Wyszukaj" name="submit"><br>
                
            </form> 
        </div> 
        
        <div class="col-sm-8 text-left ">  
            <?php if ($_SERVER['REQUEST_METHOD']=="POST"  && isset($_POST['name'])) { 
                      $productName=trim($_POST['name']); 
                      Product::loadProductsSearchByAdmin($conn, $productName);
                  }
