<?php


require_once __DIR__.'/require_once.php'; 
 
if (!isset($_SESSION['logged'])) {
    header('Location:log.php');
    exit();
} ?> 

<!DOCTYPE html>
<html>
    <head>
        <title> Wszukaj</title>

    <?php include __DIR__ . '/nav.php' ?><br><br><br><br>
    
    <body> 
        <ol class="breadcrumb">
           <li><a href="index.php">Home</a></li>
           <li><a href="products.php">Zarządzanie produktem</a></li>
           <li class="active">Wszystkie produkty</li>
        </ol><br>
        
        <div class="col-sm-6 text-left  ">   
           
                <form role="form" method="POST" action="#"> 
                
                    <div class="form-group"><br>
                        <label for="name">Nazwa przedmiotu</label>
                        <input type="text" class="form-control"  id="name" name="name" >
                    </div>
                     <input class="btn btn-info" type="submit" value="Wyszukaj" name="submit"><br>
                
                </form>    
                
                <form role="form" method="POST" action="#"> 
               
                    <div class="form-group"><br>
                        <label for="category">Kategoria</label>
                        <select class="form-control" id="category" name="category">
                            <option value="0">Wybierz kategorię</option> 
                            <?php
                                $allCategories = Category::loadAllCategories($conn);
                                foreach ($allCategories as $category) {
                                    echo "<option value='" . $category->getCategoryId() . "'>" . $category->getCategoryName() . "</option>";
                                }?>
                        </select>
                    </div>
                    <input class="btn btn-info" type="submit" value="Wyszukaj" name="submit"><br>
                </form>  
        </div><br> 
        
        <div class="col-sm-6 text-left  ">    
                <form role="form" method="POST" action="#"> 
                
                    <div class="form-group"><br>
                        <label for="name">Wyszukaj po cenie</label>
                    </div>
                    <input class="btn btn-info" type="submit" value="Wyszukaj" name="price"><br>
                
                </form>     
            
                <form role="form" method="POST" action="#"> 
                
                    <div class="form-group"><br>
                        <label for="name">Wyszukaj po ilości</label>
                    </div>
                    <input class="btn btn-info" type="submit" value="Wyszukaj" name="quantity"><br>
                
                </form>  
        
        </div><br>
      
              


 <?php   
 
    if ($_SERVER['REQUEST_METHOD']=="POST" ) { 
        if (isset($_POST['name'])) { 
                    $productName=trim($_POST['name']); 
                    
                    displayTitleLoadAll(); 
                    $loadedProducts=Product::loadProductByName($conn, $productName);  
                    
                    foreach($loadedProducts as $product){
                       $product->showProductsForAdmin();
                    }  
        }
        if (isset($_POST['category'])) {
                    $category_id = trim($_POST['category']); 
                        
                    displayTitleLoadByCategory(); 
                    $loadedProducts=Product::loadAllProductFromCategory($conn, $category_id); 
                        
                    foreach($loadedProducts as $product){ 
                        $product->showProductsFromCategory();
                      
                    } 
        } 
        if (isset($_POST['price'])) {
      
                    displayTitleLoadAll(); 
                    $loadedProducts=Product::SortProductByPrice($conn); 
                        
                    foreach($loadedProducts as $product){ 
                        $product->showProductsForAdmin();
                      
                    } 
        } 
        if (isset($_POST['quantity'])) {
      
                    displayTitleLoadAll(); 
                    $loadedProducts=Product::SortProductByQuantity($conn); 
                        
                    foreach($loadedProducts as $product){ 
                        $product->showProductsForAdmin();
                      
                    }  
        }
    } 
      else {
        displayTitleLoadAll(); 
        $loadedProducts=Product::loadAllProducts($conn); 
        
        foreach($loadedProducts as $product){ 
            $product->showProductsForAdmin();                   
        } 
    }