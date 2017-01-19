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
class Product{ 
    
    private $id; 
    private $name; 
    private $price;
    private $description; 
    private $quantity; 
    private $category_id; 
    private $category_name; 
    private $image_link;
    
    public function __construct($name = "", $price = 1.00, $description = "", $quantity = 1, $idCategory = 1){ 
        $this->id = -1;
        $this->setName($name);
        $this->setPrice($price);
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
                . "VALUES ('$this->name', $this->price,'$this->description', $this->quantity,"
                . "$this->category_id)";
                    
            $result = $conn->query($sql);
            if($result == true){
                
                $this->id = $conn->insert_id;
                return true;
            } 
        }else{ 
            
            $sql="UPDATE Product SET name='$this->name' ,price=$this->price,"
                . "description='$this->description', quantity=$this->quantity,"
                . "category_id=$this->category_id WHERE id=$this->id";
            
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
        
        $sql = "SELECT * FROM Product  WHERE id=$id";
        
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
            
            // cholera wie czy tak sie da
            
            // Zastanawiam się ciągle czy w ogóle trzeba? W sensie przy tworzeniu 
            // produktu bedziemy inicjowac obiekt klasy Image do ktorego wpiszemy id
            // tego wlasnie produktu wiec pozniej w ten sposob bedzie mozna dojsc do 
            // korealacji... ale wiadomo, mozna i w jednej metodzie to zrobic i moze
            // z użyciem np array_merge(stworzyc tutaj nowy obiekt klasy Image, 
            // przypisac jego wartosci w postaci asocjacyjnej (tak jak się to ma w $loadedProdukt), 
            // a nastepnie polaczyc przez array_merge tablice z danymi z Image z $loadedProdukt)
            // 
            // Ponizej wklejam prosty przyklad ktory pokazuje,
            // ze juz teraz mozna dojsc do latwego dostepu do linkow zdjec(jesli chcesz to wklej 
            // sobie ten kod pod klasa Product i odpal):
            
            /*
               require_once 'Image.php';
               $p = new Product('kot', 20, 'w butach byl sobie kot', 1, 2);
               $i = new Image('Images/1/1.jpg', $p);
               echo $i->getImageId().'<br>';
               echo $i->getImageLink().'<br>';
               echo $i->getProductId().'<br>';
              
                //ewentualnie: var_dump($i);   i wsio
            */
            
            // Moge się mylić oczywiście!! Wciąz się uczymy w końcu!! :-) No i może
            // o co innego Ci chodzilo, a ja sie wpierdzielam jak zwykle... :P
      
            
 
        }
        return null; 
    }
    static public function loadAllProducts(mysqli $conn){
        
        $sql = "SELECT * FROM Product JOIN Category ON Category.category_id = Product.category_id "
                . " JOIN Image ON Image.product_id=Product.id ORDER BY id DESC";
        $ret = [];
        
        $result = $conn->query($sql);
        if($result == true && $result->num_rows != 0){
            echo '<table class="table table-striped">'; 
            echo '<tr><th> Id </th><th> Nazwa </th><th> Cena </th><th> Opis </th><th> '
            . 'Ilosć dostępna </th><th> Kategoria </th><th>Zdjęcie</th><th> Edytuj </th><th> Usuń </th><tr>' ; 
            
            foreach($result as $row){
                $loadedProduct = new Product();
                $loadedProduct->id = $row['id'];
                $loadedProduct->name = $row['name'];
                $loadedProduct->price = $row['price'];
                $loadedProduct->description = $row['description']; 
                $loadedProduct->quantity = $row['quantity']; 
                $loadedProduct->category_id = $row['category_id']; 
                $loadedProduct->category_name = $row['category_name']; 
                $loadedProduct->image_link = $row['image_link'];
               
                echo '<tr><td>'.$row['id']; 
                echo '</td><td style="width: 100px">'.$row['name']; 
                echo '</td><td style="width: 100px">'.$row['price'] ; 
                echo '</td><td style="width: 100px">'.$row['description'];
                echo '</td><td style="width: 100px">'.$row['quantity']; 
                echo '</td><td style="width: 100px">'.$row['category_name'];  
                echo '</td><td style="width: 100px"><img src="'.$row['image_link'].'" class="img-responsive"/> ';  
                echo '</td><td><a href="editProduct.php?id='.$row['id'].'">Edytuj</a>';
                echo '</td><td><a href="deleteProduct.php?id='.$row['id'].'">Usuń</a>';
                echo '</td><tr>';
                $ret[] = $loadedProduct;
            }
        }
        return $ret;
    }    
    
    public static function loadAllProductFromCategory(mysqli $conn, $category_id) { 
        
       
        $sql = "SELECT * FROM Product JOIN Image ON Image.product_id=Product.id WHERE category_id = $category_id";
         $ret = [];
        $result = $conn->query($sql); 
        if ($result == true && $result->num_rows > 0){ 
            echo '<table class="table table-striped">'; 
            echo '<tr><th> Id </th><th> Nazwa </th><th> Cena </th><th> Opis </th><th> '
            . 'Ilosć dostępna </th><th>Zdjęcie</th><th> Edytuj </th><th> Usuń </th><tr>' ; 
           
            foreach ($result as $row){
                $loadedProduct = new Product();
                $loadedProduct->id = $row['id'];
                $loadedProduct->name = $row['name'];
                $loadedProduct->description = $row['description'];
                $loadedProduct->price = $row['price'];
                $loadedProduct->quantity = $row['quantity'];
                $loadedProduct->category_id = $row['category_id']; 
                $loadedProduct->image_link = $row['image_link'];
                
                echo '<tr><td>'.$row['id']; 
                echo '</td><td style="width: 100px">'.$row['name']; 
                echo '</td><td style="width: 100px">'.$row['price'] ; 
                echo '</td><td style="width: 100px">'.$row['description'];
                echo '</td><td style="width: 100px">'.$row['quantity']; 
              
                echo '</td><td style="width: 100px"><img src="'.$row['image_link'].'" class="img-responsive"/> ';  
                echo '</td><td><a href="editProduct.php?id='.$row['id'].'">Edytuj</a>';
                echo '</td><td><a href="deleteProduct.php?id='.$row['id'].'">Usuń</a>';
                echo '</td><tr>';
                
                $ret[] = $loadedProduct;
            } 
            return $ret;
        }
       return $ret;
    }
      
   
}   