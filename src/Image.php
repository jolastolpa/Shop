<?php 

/*
CREATE TABLE `Image`(
image_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
product_id INT NOT NULL,
image_link VARCHAR(255) NOT NULL,
FOREIGN KEY(product_id) REFERENCES Product(id)
ON DELETE CASCADE
)
*/

class Image {
    
    private $image_id;
    private $product_id;
    private $image_link;
    
    
    public function __construct($image_id = -1, $image_link = "", Product $product = NULL) {
        
        $this->setId($image_id);
        $product != NULL ? $this->setProductId($product->getId()) : $this->setProductId(-1);  
        $this->setImageLink($image_link);
    } 
    
    
    // setery
    public function setId($newId){
        
        if(is_int($newId)){
            $this->image_id = $newId;
        }
    }
    
    public function setProductId($newProductId){
        
        if(is_int($newProductId)){
            $this->product_id = $newProductId;
        }
    }
    
    public function setImageLink($newImageLink){
        
        if(is_string($newImageLink) && strlen($newImageLink) > 0){
            $this->image_link = $newImageLink;
        }
    }
    
    
    // getery
    public function getProductId() {
        
        return $this->product_id;
    }
    public function getImageId(){
        
        return $this->image_id;
    }
    
    public function getImageLink(){
        
        return $this->image_link;
    }
   

    // operacje na bazie danych
    public function saveToDb(mysqli $conn) { 
        
        if($this->image_id == -1){
        
            $sql = "INSERT INTO Image(product_id, image_link)"
                . "VALUES ('$this->product_id', '$this->image_link')";
                    
            $result = $conn->query($sql);
            if($result == true){
                
                $this->image_id = $conn->insert_id;
                return true;
            } 
        }else{ 
            
            $sql = "UPDATE Image SET product_id='$this->product_id', "
               . "image_link='$this->image_link' WHERE image_id='$this->image_id'";
            
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
 
    static public function loadImageById(mysqli $conn, $imageId){
        
        $sql = "SELECT * FROM Image WHERE image_id='$imageId'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedImage = new Image();
            $loadedImage->image_id = $row['image_id'];
            $loadedImage->product_id = $row['product_id'];
            $loadedImage->image_link = $row['image_link'];
            
            return $loadedImage;
        }
        return null; 
    }
    
    
   
   static public function loadImageLinksByProductId(mysqli $conn, $productId){
        
        $sql = "SELECT image_link FROM Image WHERE product_id='$productId'";
        
        $arr = []; 
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows > 0){
            
            foreach($result as $row){
                
                $arr[] = $row['image_link'];
            }
            return $arr;
        }
        return null;
    }   
}