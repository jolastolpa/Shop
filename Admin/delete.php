<?php

require_once __DIR__.'/require_once.php'; 

if (!isset($_SESSION['logged'])) {
    header('Location:log.php');
    exit();
}  
 
    if(isset($_POST['submit'])){   
        if(isset ($_GET['id'])){ 
            $id=$_GET['id']; 
            $loadProduct=  Product::loadProductById($conn, $id);
            $loadProduct->delete($conn);  
            $_SESSION['delete']="Ununięto produkt" ; 
            header('location:searchProducts.php');   
        } 
        if(isset($_GET['idCategory'])) { 
            $id=$_GET['idCategory']; 
            $loadCategory= Category::loadCategoryById($conn, $id);
            $loadCategory->deleteCategory($conn);  
            $_SESSION['deleteCategory']="Ununięto kategorie" ; 
            header('location:categories.php');   
        }
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <title> Usuń </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css" type="text/css" /> 
        <?php include __DIR__ . '/nav.php' ?><br><br><br><br>
    </head>
    <body> 
        <ol class="breadcrumb">
           <li><a href="index.php">Home</a></li>
           <li><a href="products.php">Zarządzanie produktem</a></li> 
           <li><a href="searchProducts.php">Wyszukaj</a></li>
           <li class="active">Usuń </li>
        </ol><br><br><br> 
        
   
        <div class="col-md-8 text-left "> 
            <h4> Na pewno chcesz usunąć ??? </h4> 
            <form method="POST" > 
            <input class="btn btn-danger" type="submit" value="Usuń" name="submit"><br>
            <form>
 