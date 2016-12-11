<?php

class Product { 
    
    private $id; 
    private $name; 
    private $price;
    private $description; 
    private $quantity; 
    private $idCategory;
    


    public function __construct() {

        $this->id = -1;
        $this->name = "";
        $this->price = "";
        $this->description= ""; 
        $this->quantity= ""; 
        $this->idCategory="";
    }

    public function setName($NewName) { 
        if(name>1){
        $this->name = $NewName;
        } else{ 
            throw new TooShortExeption('It should be more than 1 letter!');
          } 
    }

    public function setPrice($newPrice) { 
        if(price>0.00) { 
        $this->price = $newPrice; 
        }else { 
            throw new PriceExeption ('Price mustbe>0.00');
        }
    }

    public function setDescripion($NewDescription) { 
        if(description>1) { 
        $this->description = $NewDescription; 
        }else { 
            throw new TooShortExeption('It should be more than 1 letter!');
        }
    }  
    public function setQuantity($NewQuantity) {
        $this->quantity = $NewQuantity;
    } 
    public function setIdCategory($NewIdCategory) {
        $this->idCategory = $NewIdCategory;
    }
    
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->Name;
    }

    public function getPrice() {
        return $this->Price;
    }

    public function getDescription() {
        return $this->description;
    }  
    public function getQuantity() {
        return $this->quantity;
    }  
    public function getIdCategory() {
        return $this->idCategory;
    } 
    
    
    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
        
            $sql = "INSERT INTO Products(name, price, description,quantity,idCategory) "
                 . "VALUES ('$this->name', '$this->price','$this->description', '$this->quantity','$this->idCategory) ";
                    
            $result = $conn->query($sql);
            if ($result == true) {
                $this->id = $conn->insert_id;
                return true;
            }
        } 
    }   
 
    
        
    static public function loadProductById(mysqli $conn, $id){
        $sql = "SELECT * FROM Products WHERE id=$id";
        $result = $conn->query($sql); 
    
            if($result == true && $result->num_rows == 1){
            $row = $result->fetch_assoc();
            $loadedProduct = new Product();
            $loadedProduct->id = $row['id'];
            $loadedProduct->name = $row['name'];
            $loadedProduct->price = $row['price'];
            $loadedProduct->description = $row['descrption']; 
            $loadedProduct->quantity = $row['quantity']; 
            $loadedProduct->idCategory = $row['idCategory'];
            return $loadedProduct;
            }
            return null; 
    }

    static public function loadAllProducts(mysqli $conn){
        $sql = "SELECT * FROM Products";
        $ret = [];
        $result = $conn->query($sql);
        if($result == true && $result->num_rows != 0){
            foreach($result as $row){
             $loadedProduct = new Product();
             $loadedProduct->id = $row['id'];
             $loadedProduct->name = $row['name'];
             $loadedProduct->price = $row['price'];
             $loadedProduct->description = $row['descrption']; 
             $loadedProduct->quantity = $row['quantity']; 
             $loadedProduct->idCategory = $row['idCategory'];
                $ret[] = $loadedProduct;
            }
        }
            return $ret;
    }  
    
    public function delete(mysqli $conn){
        if($this->id != -1){
            $sql = "DELETE FROM Products WHERE id=$this->id";
            $result = $conn->query($sql);
                if($result == true){
                    $this->id = -1;
                    return true;
                 }
                return false;
        } 
            return true; 
   } 
    
    
}