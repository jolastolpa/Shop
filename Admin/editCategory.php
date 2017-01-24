<?php

require_once __DIR__ . '/require_once.php';

if (!isset($_SESSION['logged'])) {
    header('Location:log.php');
    exit();
} 
if (isset($_GET['idCategory'])) { 
    $id=$_GET['idCategory']; 
    $categoryToEdit=Category::loadCategoryById($conn, $id);
    $name=$categoryToEdit->getCategoryName(); 
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
           
            $categoryToEdit->setCategoryName($_POST['name']);
            $categoryToEdit->saveToDB($conn); 
            header('Location:categories.php');
            } else {
                echo "Nie udało sie dodać kategorii" ;
            }
         
} ?>
<!DOCTYPE html>
<html>
    <head>
        <title> Edytuj Kategorie</title>

    <?php include __DIR__ . '/nav.php' ?><br><br><br><br>
    
    <body>  
        <ol class="breadcrumb">
           <li><a href="index.php">Home</a></li>
           <li><a href="categories.php">Kategorie</a></li> 
           <li class="active">Edytuj </li>
        </ol><br><br> 
        
        <div class="col-sm-8 text-left  ">   
            <form role="form" method="POST" action="#"> 
                
                <div class="form-group">
                     <label for="name">Nazwa kategorii</label>
                     <input type="text" class="form-control"  id="name" name="name"
                            value="<?php echo $name ?>"/> 
                            <?php if (isset($error['name'])) {echo $error['name']; } ?>
                </div>  
                      <input class="btn btn-success" type="submit" value="Edytuj kategorie" name="submit"><br>
            </form> 
        </div><br><br>
