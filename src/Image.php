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
    
    function getId() {
        return $this->id;
    }
    function getImageLink() {
        return $this->imageLink;
    }
    function getProductId() {
        return $this->productId;
    }
   
    function setId($id) {
        $this->id = $id;
    }
    function setImageLink($imageLink) {
        $this->imageLink = $imageLink;
    }
    function setProductId($productId) {
        $this->productId = $productId;
    }
     
}

    


