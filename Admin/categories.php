<?php

require_once __DIR__.'/require_once.php'; 
 
if (!isset($_SESSION['logged'])) {
    header('Location:log.php');
    exit();
}  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errorStart = '<span style="color:red">';
    $errorEnd = "</span>";
    $error = ''; 
    $valid=true; 
    
        if ((strlen(trim($_POST['name'])) < 2) || (strlen(trim($_POST['name'])) > 20 )) {
            $error['name'] = $errorStart . "Nazwa powinna mieć od 2 do 20 znaków !" . $errorEnd;
            $valid = false;
        } 
        if ($valid) {
            $newCategory = new Category();
            $newCategory->setCategoryName($_POST['name']);
            $newCategory->saveToDB($conn);

            if ($newCategory->saveToDB($conn)) {
                $_SESSION['addCategory'] = "Dodano kategorię"; 
                header('Location:categories.php');
            } else {
                echo "Nie udało sie dodać kategorii" . $mysqli->error;
            }
        } 
} ?>
<!DOCTYPE html>
<html>
    <head>
        <title> Kategorie</title>

    <?php  include __DIR__ . '/nav.php' ?><br><br><br><br>
    
    <body> 
        <div class="col-sm-8 text-left  ">   
            <form role="form" method="POST" action="#"> 
                
                <div class="form-group">
                     <label for="name">Nazwa kategorii</label>
                     <input type="text" class="form-control"  id="name" name="name"/> 
                            <?php if (isset($error['name'])) {echo $error['name']; } ?>
                </div>  
                      <input class="btn btn-success" type="submit" value="Dodaj kategorie" name="submit"><br>
            </form> 
        </div><br><br>
        <div class="col-sm-8 text-left  ">   
            <h3>Wszystkie kategorie dostępne w sklepie:<h3> 
             <?php
                    displayCategories(); 
                    $loadedCategories=Category::loadAllCategories($conn); 
                        
                        foreach($loadedCategories as $category){
                           $category->showCategoriesForAdmin();
                        } ?>
        </div>
