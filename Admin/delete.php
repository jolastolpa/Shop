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
            header('location:searchProducts.php');   
        } 
        if(isset($_GET['idCategory'])) { 
            $id=$_GET['idCategory']; 
            $loadCategory= Category::loadCategoryById($conn, $id);
            $loadCategory->deleteCategory($conn);  
            header('location:categories.php');   
        } 
         if(isset($_GET['idOrder'])) { 
            $id=$_GET['idOrder']; 
            $loadOrder= Order::loadOrderByItsOwnId($conn, $id);
            $loadOrder->deleteOrder($conn);   
            header('location:orders.php');   
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
       <div class="col-md-8 text-left "> 
            <h4> Na pewno chcesz usunąć ??? </h4> 
            <form method="POST" > 
            <input class="btn btn-danger" type="submit" value="Usuń" name="submit"><br>
            <form>
 