<?php

require_once __DIR__.'/../src/Category.php';


class TestProduct extends PHPUnit_Framework_TestCase{ 
    
    private $category;
    
    // inicjacja obiektu klasy Category
    protected function setUp(){ 
        
        $this->category = New Category();
    }
    
    // test dzialania konstruktora klasy Category
    public function testIfCreationIsCorrect(){ 
        
        $this->assertEquals(-1, $this->category->getId()); 
        $this->assertEquals('', $this->category->getName());
         
    }  
    
   
    public function testSetGetName(){  
        
        $this->category->setName("furniture"); 
        $this->assertEquals("furniture", $this->category->getName());  
    } 
    

}