<?php 

require_once __DIR__ . '/require_once.php';

if (!isset($_SESSION['logged'])) {
    header('Location:log.php');
    exit();
} 
if (isset($_GET['id'])) { 
    $id=$_GET['id']; 
    $productToEdit=Product::loadProductById($conn, $id); 
    // wyciągam dane z produktu by obecne dane pojawiły sie w formularzu
    $name=$productToEdit->getName(); 
    $price=$productToEdit->getPrice(); 
    $quantity=$productToEdit->getQuantity(); 
    $description=$productToEdit->getDescription(); 
    $categoryName=$productToEdit->getCategoryName(); 
    
    $imageToEdit=Image::loadImagesByProductId($conn, $id);    
    
} else { 
    header('Location:searchProducts.php');
  }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errorStart = '<span style="color:red">';
    $errorEnd = "</span>";
    $error = '';

    if (isset($_POST['name']) || isset($_POST['price']) || isset($_POST['quantity']) || isset($_POST['description'])) {

        $valid = TRUE; // zakładam prawidłowe dodanie danych  


        if ((strlen(trim($_POST['name'])) < 2) || (strlen(trim($_POST['name'])) > 20 )) {
            $error['name'] = $errorStart . "Nazwa powinna mieć od 2 do 20 znaków !" . $errorEnd;
            $valid = false;
        }
        if ($_POST['price'] <= 0) {
            $error['price'] = $errorStart . "Naprawdę chcemy sprzedawać za 0zł ? Raczej nie!" . $errorEnd;
            $valid = false;
        }
        if ($_POST['quantity'] <= 0) {
            $error['quantity'] = $errorStart . "Ilośc produktu musi być >0!" . $errorEnd;
            $valid = false;
        }
        if ($_POST['category'] <= 0) {
            $error['category'] = $errorStart . "Wybierz kategorie!" . $errorEnd;
            $valid = false;
        }
        if ((strlen(trim($_POST['description'])) < 2) || (strlen(trim($_POST['description'])) > 400)) {
            $error['description'] = $errorStart . "Opis musi mieć od 2 do 400 znaków!" . $errorEnd;
            $valid = false;
        }

        if ($valid) {
        
            $productToEdit->setName($_POST['name']);
            $productToEdit->setPrice($_POST['price']);
            $productToEdit->setQuantity($_POST['quantity']);
            $productToEdit->setProductCategoryId($_POST['category']);
            $productToEdit->setDescription($_POST['description']);
            $productToEdit->saveToDB($conn);

           
        }
    }

    if (isset($_FILES['fileToUpload'])) {
        
        $uploadDir = '../Images';

        if (is_dir($uploadDir . '/' . $id)) {
            echo $uploadDir . '/' . $id . 'exists<br>';
        } else {
            mkdir($uploadDir . '/' . $id);
            echo $uploadDir . '/' . $id . 'created<br>';
        }

        $file = $uploadDir . '/' . $id . '/' . basename($_FILES['fileToUpload']['name']);
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file)) {
            
            $imageToEdit->setImageLink($file);
            $imageToEdit->saveToDb($conn);
        }
        
    } 
}
?>  

<!DOCTYPE html>
<html>
    <head>
        <title> Edytuj produkt</title> 
        <?php //include __DIR__ . '/nav.php' ?><br><br><br><br>
    </head>
      <body> 
        <ol class="breadcrumb">
           <li><a href="index.php">Home</a></li>
           <li><a href="products.php">Zarządzanie produktem</a></li> 
            <li><a href="searchProducts.php">Wyszukiwanie produktu</a></li>
           <li class="active">Dodaj produkt</li>
        </ol><br> 
        
        <div class="col-sm-8 text-left panel panel-success "> 
           
            <form enctype="multipart/form-data" role="form" method="POST" action="#"> 
                
                <div class="form-group">
                     <label for="name">Nazwa przedmiotu</label>
                     <input type="text" class="form-control"  id="name" name="name" 
                            value="<?php $value= isset($form['name']) ? $form['name'] : $name; echo $value; ?>"/> 
                            <?php if (isset($error['name'])) {echo $error['name']; } ?>
                </div> 
                
                <div class="form-group">
                    <label for="price">Cena</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01"
                           value="<?php $value= isset($form['price']) ? $form['price'] : $price; echo $value;  ?>"/> 
                            <?php if (isset($error['price'])) {echo $error['price'];} ?>
                </div>  
                
                <div class="form-group">
                    <label for="quantity">Ilość</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" 
                           value="<?php $value= isset($form['quantity']) ? $form['quantity'] : $quantity; echo $value; ?>"/> 
                            <?php if (isset($error['quantity'])) {echo $error['quantity'];} ?>
                </div>   
                
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
                            <?php
                             if (isset($error['category'])) {echo $error['category'];} ?>  
                </div>  
                
                <div class="form-group"> 
                    
                    <label for="description">Opis</label>
                    <textarea class="form-control" rows="3" name="description">
                            <?php $value=isset($form['description']) ? $form['description'] : $description; echo $value;?>
                    </textarea>  
                           <?php if (isset($error['description'])) {echo $error['description'];} ?>
                </div>    
                
                <div class="form-group">
                          
                            <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" <br>
                            <?php if(isset($error['fileToUpload'])) {echo $error['fileToUpload'];} ?>
                </div> 
                <input type="hidden"name="tweetId"value="<?php if (isset($_GET['id'])) echo $_GET['id'];?>">
                
                <input class="btn btn-success" type="submit" value="Edytuj produkt" name="submit"><br>
                
            </form> 
        </div>
        