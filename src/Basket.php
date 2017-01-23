<?php

/*
CREATE TABLE Basket(
basket_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
user_id INT NOT NULL,
product_id INT NOT NULL,
product_amount INT,
product_price FLOAT,
product_total_price FLOAT,
FOREIGN KEY (user_id) REFERENCES User(id) 
ON DELETE CASCADE,
FOREIGN KEY (product_id) REFERENCES Product(id) 
ON DELETE CASCADE
)
*/

require_once 'Product.php';

class Basket{
    
    private $basket_id; 
    private $user_id;
    private $product_id;
    private $product_amount;
    private $product_price;
    private $product_total_price;
    
    public function __construct(Product $product = NULL, $user_id = 0, $amount = 0){
        
        $this->basket_id = -1;
        $this->user_id = $user_id;
        $product != NULL ? $this->product_id = $product->getId() : $this->product_id = -1;
        $this->setProductAmount($amount);
        $product != NULL ? $this->product_price = $product->getPrice() : $this->product_price = -1;
        $this->product_total_price = $this->getTotalPrice();
    }
    

    // setery
    public function setProductAmount($amount){
        
        if(is_numeric($amount) && $amount >= 0){
            
            $this->product_amount = $amount;
            
            // przeliczam na nowo cene calkowita po zmianie ilosci produktu
            $this->product_total_price = $this->getTotalPrice();
        }
    }
    
    
    //getery
    public function getBasketId(){
        
        return $this->basket_id;
    }
    
    public function getUserId(){
        
        return $this->user_id;
    }
    
    public function getProductId(){
        
        return $this->product_id;
    }
    
    public function getProductAmount(){
        
        return $this->product_amount;
    }
    
    public function getProductPrice(){
        
        return $this->product_price;
    }
        
    public function getTotalPrice(){
        
        return $this->product_total_price = $this->product_amount * $this->product_price;
    }

    
    // operacje na bazie danych
    public function saveToDB(mysqli $conn){
        
        if($this->basket_id == -1){
            
            $sql = "INSERT INTO Basket(user_id, product_id, product_amount, product_price, "
                 . "product_total_price) VALUES ('$this->user_id', '$this->product_id', "
                 . "'$this->product_amount', '$this->product_price', '$this->product_total_price')";

            $result = $conn->query($sql);
            if($result == true){
                
                $this->basket_id = $conn->insert_id;
                return true;
            } 
        }else{ 
            
            $sql="UPDATE Basket SET product_amount='$this->product_amount', "
               . "product_total_price='$this->product_total_price' WHERE basket_id='$this->basket_id'";
            
            $result = $conn->query($sql);
            if($result == true){              
                return true;
            }
        }
        return false;
    } 
    
    public function delete(mysqli $conn){
        
        if($this->basket_id != -1){
            
            $sql = "DELETE FROM Basket WHERE basket_id='$this->basket_id'";
            
            $result = $conn->query($sql);
            if($result == true){
                $this->basket_id = -1;
                return true;
            }
            return false;
        } 
        return true; 
    }
    
    static public function loadOneProductInBasketById(mysqli $conn, $id){
        
        $sql = "SELECT * FROM Basket WHERE basket_id='$id'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedProduct = new Basket();
            $loadedProduct->basket_id = $row['basket_id'];
            $loadedProduct->user_id = $row['user_id'];
            $loadedProduct->product_id = $row['product_id'];
            $loadedProduct->product_amount = $row['product_amount']; 
            $loadedProduct->product_price = $row['product_price'];
            $loadedProduct->product_total_price = $row['product_total_price']; 
            
            return $loadedProduct;
        }
        return null; 
    }
    
    static public function loadAllProductsInBasketByUserId(mysqli $conn, $id){
        
        $sql = "SELECT * FROM Basket WHERE user_id='$id'";
        
        $ret = [];
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows != 0){            
            
            foreach($result as $row){
                $loadedProduct = new Basket();
                $loadedProduct->basket_id = $row['basket_id'];
                $loadedProduct->user_id = $row['user_id'];
                $loadedProduct->product_id = $row['product_id'];
                $loadedProduct->product_amount = $row['product_amount']; 
                $loadedProduct->product_price = $row['product_price'];
                $loadedProduct->product_total_price = $row['product_total_price']; 
                
                $ret[] = $loadedProduct;
            }
            return $ret;
        }
        return null; 
    }
}