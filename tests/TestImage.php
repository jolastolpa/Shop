<?php


require_once __DIR__.'/../src/Image.php';


class TestImage extends PHPUnit_Framework_TestCase{ 
    
    private $image;
    
    // inicjacja obiektu klasy Image
    protected function setUp(){ 
        
        $this->image = New Image();
    }
    
    // test dzialania konstruktora klasy Category
    public function testIfCreationIsCorrect(){ 
        
        $this->assertEquals(-1, $this->image->getImageId()); 
        $this->assertEquals('', $this->image->getImageLink()); 
        $this->assertEquals(-1, $this->image->getProductId());
         
    }  
    
   
    public function testSetGetImageLink(){  
        
        $this->image->setImageLink("Images/1/1.jpg"); 
        $this->assertEquals("Images/1/1.jpg", $this->image->getImageLink());  
    } 
    public function testSetGetProductId(){  
        
        $this->image->setProductId(1); 
        $this->assertEquals(1, $this->image->getProductId());  
    } 
    
}