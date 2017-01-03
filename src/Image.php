<?php 

/*
CREATE TABLE `Images`(
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
imageLink MEDIUMBLOB,
productId INT,
FOREIGN KEY(productId) REFERENCES Products(id)
ON DELETE CASCADE
)
*/

class Image {
    
    private $id;
    private $imageLink;
    private $productId;
    
    
    
    public function __construct($id = -1, $imageLink = null, $productId = null) {
        $this->id = $id;
        $this->setImageLink($imageLink);
        $this->setProductId($productId);
        
    } 
    
    public function getId() {
        return $this->id;
    }
    public function getImageLink() {
        return $this->imageLink;
    }
    public function getProductId() {
        return $this->productId;
    }
   
    public function setId($id) {
        $this->id = $id;
    }
    public function setImageLink($imageLink) {
        $this->imageLink = $imageLink;
    }
    public function setProductId($productId) {
        $this->productId = $productId;
    }
    
    public function saveToDb(mysqli $conn) { 
        
        if($this->id == -1){
        
            $sql = "INSERT INTO Images(id, imageLink, productId)"
                . "VALUES ($this->id, '$this->imageLink','$this->productId,)";
                    
            $result = $conn->query($sql);
            if($result == true){
                
                $this->id = $conn->insert_id;
                return true;
            } 
        }else{ 
            
            $sql="UPDATE Images SET imageLink='$this->imageLink', "
                    . "productId='$this->productId WHERE id='$this->id'";
            
            $result = $conn->query($sql);
            if($result == true){              
                return true;
            }
        }
        return false;
    } 
      
    public function delete(mysqli $conn){
        
        if($this->id != -1){
            
            $sql = "DELETE FROM Images WHERE id='$this->id'";
            
            $result = $conn->query($sql);
            if($result == true){
                $this->id = -1;
                return true;
            }
            return false;
        } 
        return true; 
    }
 
    static public function loadImageById(mysqli $conn, $id){
        
        $sql = "SELECT * FROM Images WHERE id='$id'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedImage = new Image();
            $loadedImage->id = $row['id'];
            $loadedImage->imageLink = $row['imageLink'];
            $loadedImage->productId = $row['productId'];
            
            return $loadedImage;
        }
        return null; 
    }
    
    static public function loadAllImagesByProductId (mysqli $conn, $productId) { 
        if($this->id != -1){
            
            $sql="SELECT Images.imageLink FROM Products JOIN Images ON 
                Products.id=Pictures.productId WHERE Products.id=$productId ";
            
            $ret=[]; 
            $result = $conn->query($sql);
            if($result == true && $result->num_rows != 0){
            
            foreach($result as $row){
                $loadedImage = new Image();
                $loadedImage->imageLink = $row['imageLink'];
              
                
                $ret[] = $loadedImage;
            }
        }
        return $ret;
        }
    }
            
}

    


