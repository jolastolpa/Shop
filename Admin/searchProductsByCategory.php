<?php


session_start();  
require_once __DIR__.'/../config.php'; 
require_once __DIR__.'/../src/Product.php'; 
require_once __DIR__.'/../src/Image.php';  
require_once __DIR__.'/../src/Admin.php'; 
require_once __DIR__.'/../src/Category.php'; 
require_once __DIR__.'/../src/index.html'; 
require_once __DIR__.'/html.php'; 

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
           <li class="active">Wyszukaj po kategorii </li>
        </ol><br><br><br> 
        
   
        <div class="col-md-8 text-left panel panel-success "> 
           
            <form role="form" method="POST" action="#"> 
                <div class="form-group">
                    <label for="category">Kategoria</label>
                        <select class="form-control" id="category" name="category">
                            <option value="0">Wybierz kategorię</option> 
                            <?php
                                $allCategories = Category::loadAllCategories($conn);
                                foreach ($allCategories as $category) {
                                    echo "<option value='" . $category->getCategoryId() . "'>" . $category->getCategoryName() . "</option>";
                                }?>
                        </select>
               
                </div><br<br>
                    <input class="btn btn-info" type="submit" value="Wyszukaj" name="submit"><br>
            </form> 
        </div> 
        
        <div class="col-md-8 text-left ">  
            <?php   if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['category'])) {
                        $category_id = trim($_POST['category']); 
                        
                        displayTitleLoadByCategory(); 
                        $loadedProducts=Product::loadAllProductFromCategory($conn, $category_id); 
                        
                        foreach($loadedProducts as $product){
                            echo '<tr><td>'.$product->getId(); 
                            echo '</td><td >'.$product->getName(); 
                            echo '</td><td >'.$product->getPrice() ; 
                            echo '</td><td >'.$product->getDescription();
                            echo '</td><td >'.$product->getQuantity();
                            echo '</td><td style="width: 100px"><img src="'.$product->getImageLink().'" class="img-responsive"/> ';  
                            echo '</td><td><a href="editProduct.php?id='.$product->getId().'">Edytuj</a>';
                            echo '</td><td><a href="deleteProduct.php?id='.$product->getId().'">Usuń</a>';
                            echo '</td><tr>';
                        } 
                    }
            ?> 
        </div>


