<?php

//require_once __DIR__.'/vendor/autoload.php'; // - mi ta ścieżka  nie działa,próbowąłam na wiele spodobób nie wiem czemu

// Poprawiona sciezka. Po wpisaniu w konsoli komendy; 
// './tests/vendor/bin/phpunit tests/TestProduct.php'
// gra i buczy! ;-)
require_once __DIR__.'/../src/Product.php';


class TestProduct extends PHPUnit_Framework_TestCase{ 
    
    private $product;
    
    // inicjacja obiektu klasy Product
    protected function setUp(){ 
        
        $this->product = New Product();
    }
    
    // test dzialania konstruktora klasy Product
    public function testIfCreationIsCorrect(){ 
        
        $this->assertEquals(-1, $this->product->getId()); 
        $this->assertEquals('', $this->product->getName());
        $this->assertEquals(1, $this->product->getPrice());    
        $this->assertEquals('', $this->product->getDescription()); 
        $this->assertEquals(1, $this->product->getQuantity()); 
        $this->assertEquals(1, $this->product->getIdCategory());    
    }  
    
    // testy seterow
    public function testSetGetName(){  
        
        $this->product->setName("desk"); 
        $this->assertEquals("desk", $this->product->getName());  
    } 
    
    public function testSetGetPrice(){  
        
        $this->product->setPrice(20.00); 
        $this->assertEquals(20.00, $this->product->getPrice());   
    } 
    
    public function testSetGetDescription(){  
        
        $this->product->setDescription("beautiful"); 
        $this->assertEquals("beautiful", $this->product->getDescription()); 
    }  
    
    public function testSetGetQuantity(){ 
        
        $this->product->setQuantity(5); 
        $this->assertEquals(5, $this->product->getQuantity());
    }  
    
    public function testSetGetIdCategory(){ 
        
        $this->product->setIdCategory(1); 
        $this->assertEquals(1, $this->product->getIdCategory());
    }  
} 