<?php

require_once __DIR__.'/../src/Status.php';


class TestStatus extends PHPUnit_Framework_TestCase{ 
    
    private $status;
    
    // inicjacja obiektu klasy status
    protected function setUp(){ 
        
        $this->status = New Status();
    }
    
    // test dzialania konstruktora klasy status
    public function testIfCreationIsCorrect(){ 
        
        $this->assertEquals(-1, $this->status->getStatusId()); 
        $this->assertEquals('', $this->status->getStatusName());
         
    }  
    
    // testy seterow
    public function testSetGetName(){  
        
        $this->status->setStatusName("unconfirmed"); 
        $this->assertEquals("unconfirmed", $this->status->getStatusName());  
    } 
    
 
    
}
