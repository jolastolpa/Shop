<?php 

/*
CREATE TABLE `Image`(
image_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
image_link MEDIUMBLOB,
product_id INT,
FOREIGN KEY(product_id) REFERENCES Product(id)
ON DELETE CASCADE
)
*/

class Image {
    
    private $image_id;
    private $image_link;
    private $product_id;
    
    
    public function __construct($image_id = -1, $image_link = "", Product $product = NULL) {
        
        $this->setId($image_id);
        $this->setImageLink($image_link);
        $product != NULL ? $this->setProductId($product->getId()) : $this->setProductId(-1);  
    } 
    
    
    // setery i getery
    public function setId($newId){
        
        if(is_int($newId)){
            $this->image_id = $newId;
        }
    }
    
    public function setImageLink($newImageLink){
        
        if(is_string($newImageLink) && strlen($newImageLink) > 0){
            $this->image_link = $newImageLink;
        }
    }
    
    public function setProductId($newProductId){
        
        if(is_int($newProductId)){
            $this->product_id = $newProductId;
        }
    }
    
    public function getImageId(){
        
        return $this->image_id;
    }
    
    public function getImageLink(){
        
        return $this->image_link;
    }
    
    public function getProductId() {
        
        return $this->product_id;
    }
   

    // operacje na bazie danych
    public function saveToDb(mysqli $conn) { 
        
        if($this->image_id == -1){
        
            $sql = "INSERT INTO Image(image_id, image_link, product_id)"
                . "VALUES ($this->image_id, '$this->image_link','$this->product_id,)";
                    
            $result = $conn->query($sql);
            if($result == true){
                
                $this->image_id = $conn->insert_id;
                return true;
            } 
        }else{ 
            
            $sql="UPDATE Image SET image_link='$this->image_link', "
               . "product_id='$this->product_id WHERE image_id='$this->image_id'";
            
            $result = $conn->query($sql);
            if($result == true){              
                return true;
            }
        }
        return false;
    } 
      
    public function delete(mysqli $conn){
        
        if($this->image_id != -1){
            
            $sql = "DELETE FROM Image WHERE image_id='$this->image_id'";
            
            $result = $conn->query($sql);
            if($result == true){
                $this->image_id = -1;
                return true;
            }
            return false;
        } 
        return true; 
    }
 
    static public function loadImageById(mysqli $conn, $id){
        
        $sql = "SELECT * FROM Image WHERE image_id='$id'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedImage = new Image();
            $loadedImage->image_id = $row['image_id'];
            $loadedImage->image_link = $row['image_link'];
            $loadedImage->product_id = $row['product_id'];
            
            return $loadedImage;
        }
        return null; 
    }
    
    
   
    static public function loadImagesByProductId(mysqli $conn, $product_id){
        
        $sql = "SELECT * FROM Image WHERE product_id='$product_id'";
        $ret=[]; 
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows >0){
            
            foreach ($result as $row){
            $loadedImage = new Image();
            $loadedImage->image_id = $row['image_id'];
            $loadedImage->image_link = $row['image_link'];
            $loadedImage->product_id = $row['product_id'];
            $ret[] = $loadedImage;
            return $ret;
        }
        return null; 
    } 
    } 
    
}
    
        


    


