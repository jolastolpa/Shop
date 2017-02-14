<?php
/*
CREATE TABLE Product(
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(100),
price FLOAT,
description VARCHAR(500),
quantity INT,
category_id INT, 
FOREIGN KEY (category_id) REFERENCES Category(category_id) 
ON DELETE CASCADE
)
*/
require_once 'TooShortExeption.php';
require_once 'ZeroExeption.php'; 

require_once 'Image.php';
require_once 'Category.php';

class Product{ 
    
    private $id; 
    private $name;
    private $price;
    private $description;
    private $quantity;
    private $category_id;
    
    public function __construct($name = "", $price = 1.00, $description = "", $quantity = 1, $idCategory = 1){ 
        $this->id = -1;
        $this->setName($name);
        $this->setPrice((int)$price);
        $this->setDescription($description); 
        $this->setQuantity($quantity); 
        $this->setProductCategoryId($idCategory);
    }
    
    //setery
    public function setId($id){
        
        if(is_int($id)){
            $this->id = $id;
        }
    }
    
    public function setName($NewName){ 
        
        if(strlen($NewName) >= 0){
            $this->name = $NewName;
        }
    }
    public function setPrice($NewPrice){ 
        
        if($NewPrice > 0.00){ 
            $this->price = $NewPrice; 
        }
    }
    public function setDescription($NewDescription){ 
        
        if(strlen($NewDescription) >= 0) { 
            $this->description = $NewDescription; 
        }
    }  
    
    public function setQuantity($NewQuantity){ 
        
        if($NewQuantity > 0){ 
            $this->quantity = $NewQuantity; 
        }
    } 
    
    public function setProductCategoryId($NewIdCategory){ 
        
        if($NewIdCategory > 0){ 
            $this->category_id = $NewIdCategory; 
        }
    }
    
    // getery
    public function getId(){
        
        return $this->id;
    }
    public function getName(){
        
        return $this->name;
    }
    public function getPrice(){
        
        return $this->price;
    }
    public function getDescription(){
        
        return $this->description;
    }  
    
    public function getQuantity(){
        
        return $this->quantity;
    }  
    
    public function getProductCategoryId(){
        
        return $this->category_id;
    }
    
    
    // operacje na bazie danych
    public function saveToDB(mysqli $conn){
        
        if($this->id == -1){
        
            $sql = "INSERT INTO Product(name, price, description, quantity, category_id)"
                . "VALUES ('$this->name', '$this->price', '$this->description', '$this->quantity',"
                . "'$this->category_id')";
                    
            $result = $conn->query($sql);
            if($result == true){
                
                $this->id = $conn->insert_id;
                return true;
            } 
        }else{ 
            
            $sql="UPDATE Product SET name='$this->name' ,price='$this->price',"
                . "description='$this->description', quantity='$this->quantity',"
                . "category_id='$this->category_id' WHERE id='$this->id'";
            
            $result = $conn->query($sql);
            if($result == true){              
                return true;
            }
        }
        return false;
    } 
      
    public function delete(mysqli $conn){
        
        if($this->id != -1){
            
            $sql = "DELETE FROM Product WHERE id='$this->id'";
            
            $result = $conn->query($sql);
            if($result == true){
                $this->id = -1;
                return true;
            }
            return false;
        } 
        return true; 
    }
 
    static public function loadProductById(mysqli $conn, $id){
        
        $sql = "SELECT * FROM Product  WHERE id='$id'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedProduct = new Product();
            $loadedProduct->id = $row['id'];
            $loadedProduct->name = $row['name'];
            $loadedProduct->price = $row['price'];
            $loadedProduct->description = $row['description']; 
            $loadedProduct->quantity = $row['quantity']; 
            $loadedProduct->category_id = $row['category_id']; 
            
            return $loadedProduct; 
        } 
    }
    
    static public function loadProductByIdAndReturnAssocArr(mysqli $conn, $id){
        
        $sql = "SELECT * FROM Product WHERE id='$id'";
        
        $result = $conn->query($sql);
        
        if($result == true && $result->num_rows != 0){
            
            return self::arrayFormForOne($conn, $result);
        }
    }
    
    static public function loadAllProductsInRandomOrderAndReturnAssocArr(mysqli $conn){
        
        $sql = "SELECT * FROM Product ORDER BY RAND()";

        $result = $conn->query($sql);
        if($result == true && $result->num_rows > 0){
            
            return self::arrayFormForMany($conn, $result);
        }
    }    
    
    static public function loadAllProductsByCategoryIdAndReturnAssocArr(mysqli $conn, $category_id) { 
        
       
        $sql = "SELECT * FROM Product WHERE category_id='$category_id'";
        
        $result = $conn->query($sql); 
        if ($result == true && $result->num_rows > 0){ 
           
            return self::arrayFormForMany($conn, $result); 
        }
    } 
    
    static public function loadProductByNameAndReturnAssocArr(mysqli $conn, $name){ 
        
        $newName = '%'.$name.'%';
        
        $sql = "SELECT * FROM Product WHERE name LIKE '$newName'";

        $result = $conn->query($sql); 
        
        if ($result == true && $result->num_rows > 0){ 
           
            return self::arrayFormForMany($conn, $result); 
        }
    }
    
    
    // metody wyświetlające html 
    static public function displayProductAsHtmlInAListOfProducts($product){
        
        $productId = $product['id'];
        $productName = $product['name'];
        $productPrice = $product['price'];
        $productDesc = $product['description'];
        $productCatName = $product['category_name'];
        $productImageLinksArr = $product['image_links'][1];
        
echo <<< EOT
        <div class="padd">
            <div class="block">
                <div class="col-md-2">
                    <img src="$productImageLinksArr" class="img-rounded" 
                            alt="$productName" width="100" height="100">
                </div>
                <div class="col-md-8">
                    <h4> $productName </h4>
                    <p> $productCatName </p>
                    <p> $productDesc </p>
                </div>
                <div class="col-md-2">
                    <h4> $productPrice </h4>
                </div>
            </div>
        </div>
EOT;
    }
    
    public function showProductsForAdmin() {   
        echo '<tr><td>'.$this->getId(); 
        echo '</td><td >'. $this->getName();
        echo '</td><td >'.$this->getPrice() ; 
        echo '</td><td >'.$this->getDescription();
        echo '</td><td >'.$this->getQuantity(); 
        echo '</td><td >'.$this->getCategoryName();
        echo '</td><td style="width: 100px"><img src="'.$this->getImageLink().'" class="img-responsive"/> ';  
        echo '</td><td><a href="editProduct.php?id='.$this->getId().'">Edytuj</a>';
        echo '</td><td><a href="delete.php?id='.$this->getImageLink().'">Usuń</a>';
        echo '</td><tr>';
    } 
    
    public function showProductsFromCategoryForAdmin() {  
        echo '<tr><td>'.$this->getId();  
        echo '</td><td >'.$this->getName(); 
        echo '</td><td >'.$this->getPrice() ; 
        echo '</td><td >'.$this->getDescription();
        echo '</td><td >'.$this->getQuantity();
        echo '</td><td style="width: 100px"><img src="'.$this->getImageLink().'" class="img-responsive"/> ';  
        echo '</td><td><a href="editProduct.php?id='.$this->getId().'">Edytuj</a>';
        echo '</td><td><a href="delete.php?id='.$this->getId().'">Usuń</a>';
        echo '</td><tr>';
    }
    
    
    // metody sortujace
    static public function sortAndDisplayController(mysqli $conn, $key = null){
        
        // wczytanie tablicy produktow z bazy danych w losowej kolejnosci
        $productsArr = Product::loadAllProductsInRandomOrderAndReturnAssocArr($conn);
        
        switch ($key){
        case 1:
            $productsArr = Product::sortByIdAsc($productsArr);
            break;
        case 2:
            $productsArr = Product::sortByIdDesc($productsArr);
            break;
        case 3:
            $productsArr = Product::sortByPriceAsc($productsArr);
            break;
        case 4:
            $productsArr = Product::sortByPriceDesc($productsArr);
            break;
        case 5:
            $productsArr = Product::sortByQuantityAsc($productsArr);
            break;
        case 6:
            $productsArr = Product::sortByQuantityDesc($productsArr);
            break;
        }
        
        return self::iterateAnArrayOfProductsAndPassEachSingleProductIntoDisplayingMethod($productsArr);
    }
    
    static public function iterateAnArrayOfProductsAndPassEachSingleProductIntoDisplayingMethod($productsArr){
    
        for($i = 0; $i < count($productsArr); $i++){
            
            //var_dump($productsArr[$i]);
            self::displayProductAsHtmlInAListOfProducts($productsArr[$i]);
        } 
    }
    
    static public function sortByIdAsc($arr){
        
        usort($arr, function($a, $b) {
            return $a['id'] - $b['id'];
        });
        
        return $arr;
    }
    
    static public function sortByIdDesc($arr){

        return array_reverse(Product::sortByIdAsc($arr));
    }
    
    static public function sortByPriceAsc($arr){
        
        usort($arr, function($a, $b) {
            return $a['price'] - $b['price'];
        });
        
        return $arr;
    }
    
    static public function sortByPriceDesc($arr){

        return array_reverse(Product::sortByPriceAsc($arr));
    }
    
    static public function sortByQuantityAsc($arr){
        
        usort($arr, function($a, $b) {
            return $a['quantity'] - $b['quantity'];
        });
        
        return $arr;
    }
    
    static public function sortByQuantityDesc($arr){

        return array_reverse(Product::sortByQuantityAsc($arr));
    }
    
    // wyexportowane komponenty
    static private function arrayFormForMany(mysqli $conn, $result){
        
        foreach($result as $row){   
                
            $arr[] = [
                'id'            => $row['id'],
                'name'          => $row['name'],
                'price'         => $row['price'],
                'description'   => $row['description'], 
                'quantity'      => $row['quantity'], 
                'category_name' => Category::loadCategoryById($conn, $row['category_id'])->getCategoryName(),
                'image_links'   => Image::loadImageLinksByProductId($conn, $row['id'])
            ];
        }
        return $arr;
    }
    
    static private function arrayFormForOne(mysqli $conn, $result){
        
        foreach($result as $row){   
                
            $one = [
                'id'            => $row['id'],
                'name'          => $row['name'],
                'price'         => $row['price'],
                'description'   => $row['description'], 
                'quantity'      => $row['quantity'], 
                'category_name' => Category::loadCategoryById($conn, $row['category_id'])->getCategoryName(),
                'image_links'   => Image::loadImageLinksByProductId($conn, $row['id'])
            ];
        }
        return $one;
    }
}