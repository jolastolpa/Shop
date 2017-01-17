<?php

session_start();  
require_once __DIR__.'/../config.php'; 
require_once __DIR__.'/../src/Product.php'; 
require_once __DIR__.'/../src/Image.php';  
require_once __DIR__.'/../src/Admin.php'; 
require_once __DIR__.'/../src/Category.php'; 
require_once __DIR__.'/../src/index.html'; 

if(!isset($_SESSION['logged'])) { 
    header('Location:log.php');     
    exit();   
}   

if ($_SERVER['REQUEST_METHOD']=='POST'){   
    $errorStart='<span style="color:red">' ; 
    $errorEnd="</span>" ;
        if(isset($_POST['submit'])){ 
        $valid=TRUE;// zakładam prawidłowe dodanie danych
        $fields=['name','price','quantity','category','description'] ; 
        // pobieranie danych :  
        
        foreach ( $fields as $field) { 
        $form[$field]=  htmlspecialchars(trim($_POST[$field]));  
        $error[$field]=''; // zakładam brak błędów 
       
        }  
    
            if((strlen($form['name'])<2) || (strlen($form['name'])>20 )){ 
                $error['name']=$errorStart."Nazwa powinna mieć od 2 do 20 znaków !".$errorEnd ; 
                $valid=false;
            } 
            if($form['price'] <=0 ) { 
                $error['price']=$errorStart."Naprawdę chcemy sprzedawać za 0zł ? Raczej nie!".$errorEnd ; 
                $valid=false;
            }    
            if($form['quantity'] <=0 ) { 
                $error['quantity']=$errorStart."Ilośc produktu musi być >0!".$errorEnd ; 
                $valid=false;
            }
            if($form['category'] <=0) { 
                $error['category']=$errorStart."Wybierz kategorie!".$errorEnd ; 
                $valid=false;
            } 
            if ((strlen($form['description'])<2) || (strlen($form['description'])>400)) { 
                $error['description']=$errorStart."Opis musi mieć od 2 do 400 znaków!".$errorEnd ; 
                $valid=false;
            }   
            
                if($valid) {   
                    $newProduct=new Product(); 
                    $newProduct->setName($form['name']);  
                    $newProduct->setPrice($form['price']); 
                    $newProduct->setQuantity($form['quantity']); 
                    $newProduct->setProductCategoryId($form['category']); 
                    $newProduct->setDescription($form['description']); 
                    $newProduct->saveToDB($conn); 
                 
                    if($newProduct->saveToDB($conn)) {  
                       
                       $_SESSION['lastId']=$conn->insert_id();
                      //  header('location:addProduct.php');
                       
                    } else { 
                             echo "Nie udało sie dodać produktu do bazy". $mysqli->error;
                            }         
                }  
                
    } 
        if(isset($_POST['submitImage'])) {  
            if (isset($_FILES['fileToUpload'])) {   
                $lastId=$_SESSION['lastId'];
                $uploadDir='../Images' ;  
                
                if (is_dir($uploadDir . '/' . $lastId)) {
                echo $uploadDir . '/' . $lastId . 'exists<br>';
                } else {
                  mkdir($uploadDir . '/' . $lastId);
                  echo $uploadDir . '/' . $lastId . 'created<br>';
                  }

                 $file =  $uploadDir. '/' . $lastId. '/' . basename($_FILES['fileToUpload']['name']); 
                    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file)) { 
                        $images[]=$file ;  
                        foreach($images as $image){
                            $newImage=new Image(); 
                            $newImage->setImageLink($image); 
                            $newImage->setProductId($lastId); 
                            $newImage->saveToDb($conn);
                        }
                   
                        if($newImage->saveToDb($conn)) { 
                        $_SESSION['addImage']="Do produktu dodano też zdjecie";
                       // header('location:addProduct.php');
                        }
                            else { 
                                 echo "Nie udało sie dodać zdjęcia do bazy". $mysqli->error;
                            }         
                    } 
            }   
                else{
                   $error['fileToUpload'] =$errorStart."nie przesłano zdjęcia".$errorEnd;
                }       
        
        } 
} 
 
?>  

<!DOCTYPE html>
<html>
    <head>
        <title> Dodaj produkt</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css" type="text/css" /> 
        <?php include __DIR__ . '/nav.php' ?><br><br><br><br>
    </head>
    <body> 
        <ol class="breadcrumb">
           <li><a href="index.php">Home</a></li>
           <li><a href="products.php">Zarządzanie produktem</a></li>
           <li class="active">Dodaj produkt</li>
        </ol><br>
        <div class="col-sm-8 text-left panel panel-success "> 
           
            <form role="form" method="POST" action="#"> 
                
                <div class="form-group">
                     <label for="name">Nazwa przedmiotu</label>
                     <input type="text" class="form-control"  id="name" name="name" value="<?php if(isset($form['name'])) echo $form['name']; //stosowane by dobrze wprowadzone dane nie ginęły gdy pojawi sie jakiś błąd?>"/> 
                            <?php if (isset($error['name'])) {echo $error['name']; }?>
                </div> 
                
                <div class="form-group">
                    <label for="price">Cena</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01"
                           value="<?php if(isset($form['price'])){ echo $form['price'];} ?>"/> 
                            <?php if (isset($error['price'])) {echo $error['price'];} ?>
                </div>  
                
                <div class="form-group">
                    <label for="quantity">Ilość</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" 
                           value="<?php if(isset($form['quantity'])) { echo $form['quantity'];}?>"/> 
                            <?php if (isset($error['quantity'])) {echo $error['quantity'];} ?>
                </div>   
                
                <div class="form-group">
                    <label for="category">Kategoria</label>
                        <select class="form-control" id="category" name="category">
                            <option value="0">Wybierz kategorię</option> 
                            <?php echo Category::loadAllCategories($conn); ?> 
                        </select>
                            <?php
                             if (isset($error['category'])) {echo $error['category'];} ?>  
                </div>  
                
                <div class="form-group">
                    <label for="description">Opis</label>
                    <textarea class="form-control" rows="3" name="description"
                             value="<?php if(isset($form['description'])) {echo $form['description'];} ?>"/> 
                    </textarea>  
                     <?php if (isset($error['description'])) {echo $error['description'];} ?>
                </div>   
                
                <input class="btn btn-success" type="submit" value="Dodaj produkt" name="submit"><br>
                
            </form> 
        </div>
        <div class="col-sm-8 text-left panel panel-success">   
           <form method="POST"   enctype="multipart/form-data">
                     <div class="form-group">
                            <label for="fileToUpload">Dodaj zdjęcie</label> 
                            <input class="form-control" type="file" name="fileToUpload" id="fileToUpload"><br>
                            <input class="btn btn-success" type="submit" value="Dodaj zdjęcie" name="submitImage"> 
                             <?php if (isset($error['fileToUpload'])) {echo $error['fileToUpload'];} ?>
                    </div>
            </form>
        </div>
            
 
        
            