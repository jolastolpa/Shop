<?php

class Image {
    
    private $id;
    private $image_link;
    private $product_id;
    
    
    
    public function __construct($id = -1, $image_link = null, $product_id = null) {
        $this->id = $id;
        $this->setImage_link($image_link);
        $this->setProduct_id($product_id);
        
    } 
    
    function getId() {
        return $this->id;
    }
    function getImage_link() {
        return $this->image_link;
    }
    function getProduct_id() {
        return $this->product_id;
    }
   
    function setId($id) {
        $this->id = $id;
    }
    function setImage_link($image_link) {
        $this->image_link = $image_link;
    }
    function setProduct_id($product_id) {
        $this->product_id = $product_id;
    }
     
}

    


