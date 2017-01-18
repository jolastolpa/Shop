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
        <title> Szukaj po kategorii</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css" type="text/css" /> 
        <?php include __DIR__ . '/nav.php' ?><br><br><br><br>
    </head>
    <body> 
        <ol class="breadcrumb">
           <li><a href="index.php">Home</a></li>
           <li><a href="products.php">Zarządzanie produktem</a></li> 
           <li><a href="searchProducts.php">Wyszukaj</a></li>
           <li class="active">Wyszukaj po Cenie </li>
        </ol><br><br><br> 
        
   
        <div class="col-md-8 text-left panel panel-success "> 
           
            <form role="form" method="POST" action="#"> 
                <div class="form-group">
                    <label for="category">Cena:</label>
                        <select class="form-control" id="price" name="price">
                            <option value="0">Wybierz </option> 
                            <option value="1">Rosnąco </option>  
                            <option value="0">Malejąco </option> 
                        </select>
               
                </div><br<br>
                    <input class="btn btn-info" type="submit" value="Wyszukaj" name="submit"><br>
            </form> 
        </div> 
        
        <div class="col-md-8 text-left ">  
            <?php if ($_SERVER['REQUEST_METHOD']=="POST"  && isset($_POST['price'])) { 
                      $price=trim($_POST['price']);  
                      Product::loadAllProductFromCategory($conn, $category_id);
                  }  ?> 
        </div>
