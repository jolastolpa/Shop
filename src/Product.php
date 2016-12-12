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
        if(strlen($NewName)>1){
        $this->name = $NewName;
        } else{ 
            throw new TooShortExeption('It should be more than 1 letter!');
          } 
    }

    public function setPrice($newPrice) { 
        if($newPrice>0.00) { 
        $this->price = $newPrice; 
        }else { 
            throw new PriceExeption ('Price mustbe>0.00');
        }
    }

    public function setDescription($NewDescription) { 
        if(strlen($NewDescription)>1) { 
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
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
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
                 . "VALUES ('$this->name', $this->price,'$this->description', $this->quantity,$this->idCategory) ";
                    
            $result = $conn->query($sql);
            if ($result == true) {
                $this->id = $conn->insert_id;
                return true;
           
            } else { 
            $sql="UPDATE Products SET name='$this->name' ,price=$this->price,"
                    . "description='$this->description', quantity=$this->quantity,idCategory=$this->idCategory "
                    . "WHERE id=$this->id ";
        } 
        return $conn->query($sql);
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
            $loadedProduct->description = $row['description']; 
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
             $loadedProduct->description = $row['description']; 
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