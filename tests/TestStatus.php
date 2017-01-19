<?php

require_once __DIR__.'/../src/Status.php';


class TestStatus extends PHPUnit_Framework_TestCase{ 
    
    private $status;
    
    // inicjacja obiektu klasy status
    protected function setUp(){ 
        
        parent::setUp();
        $this->status = new Status('default_status');
    }
    
    // test dzialania konstruktora klasy status
    public function testIfCreationIsCorrect(){ 
        
        $this->assertEquals(-1, $this->status->getStatusId()); 
        $this->assertEquals('default_status', $this->status->getStatusName());
         
    }  
    
    // test setera
    public function testSetGetName(){  
        
        $this->status->setStatusName("unconfirmed"); 
        $this->assertEquals("unconfirmed", $this->status->getStatusName());  
    } 
    
    
    // zerowanie obiektu
    protected function tearDown(){
        
        $this->status = NULL;
    }
}
