<?php

session_start();  
require_once __DIR__.'/../config.php'; 
require_once __DIR__.'/../src/Product.php'; 
require_once __DIR__.'/../src/index.html'; 

if (!isset($_SESSION['logged'])) {
    header('Location:log.php');
    exit();
}  
 
    if(isset($_POST['submit'])){   
        $id=$_GET['id']; 
        $loadProduct=  Product::loadProductById($conn, $id);
        $loadProduct->delete($conn);  
        $_SESSION['delete']="Ununięto produkt" ; 
        header('location:searchProducts.php');   
        
    } 
    
?>


<!DOCTYPE html>
<html>
    <head>
        <title> Usuń produkt</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css" type="text/css" /> 
        <?php include __DIR__ . '/nav.php' ?><br><br><br><br>
    </head>
    <body> 
        <ol class="breadcrumb">
           <li><a href="index.php">Home</a></li>
           <li><a href="products.php">Zarządzanie produktem</a></li> 
           <li><a href="searchProducts.php">Wyszukaj</a></li>
           <li class="active">Usuń produkt </li>
        </ol><br><br><br> 
        
   
        <div class="col-md-8 text-left "> 
            <h4> Na pewno chcesz usunąć ??? </h4> 
            <form method="POST" > 
            <input class="btn btn-danger" type="submit" value="Usuń" name="submit"><br>
            <form>
 