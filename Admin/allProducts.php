<?php


require_once __DIR__.'/require_once.php'; 
 
if (!isset($_SESSION['logged'])) {
    header('Location:log.php');
    exit();
} ?> 

<!DOCTYPE html>
<html>
    <head>
        <title> Wszystkie produkty</title>

    <?php include __DIR__ . '/nav.php' ?><br><br><br><br>
    
    <body> 
        <ol class="breadcrumb">
           <li><a href="index.php">Home</a></li>
           <li><a href="products.php">Zarządzanie produktem</a></li>
           <li class="active">Wszystkie produkty</li>
        </ol><br><br><br> 
        
        <div class="col-sm-8 text-left  ">  
            <h3>Wszystkie produkty dostępne w sklepie:<h3> 
             <?php
                    displayTitleLoadAll(); 
                    $loadedProducts=Product::loadAllProducts($conn); 
                        
                        foreach($loadedProducts as $product){
                            echo '<tr><td>'.$product->getId(); 
                            echo '</td><td >'.$product->getName(); 
                            echo '</td><td >'.$product->getPrice() ; 
                            echo '</td><td >'.$product->getDescription();
                            echo '</td><td >'.$product->getQuantity();
                            echo '</td><td >'.$product->getCategoryName();
                            echo '</td><td style="width: 100px"><img src="'.$product->getImageLink().'" class="img-responsive"/> ';  
                            echo '</td><td><a href="editProduct.php?id='.$product->getId().'">Edytuj</a>';
                            echo '</td><td><a href="delete.php?id='.$product->getId().'">Usuń</a>';
                            echo '</td><tr>';
                        } 
