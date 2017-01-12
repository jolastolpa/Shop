<?php

require_once __DIR__.'/../src/Message.php';


class TestMessage extends PHPUnit_Framework_TestCase{ 
    
    private $message;
    
    // inicjacja obiektu klasy Message
    protected function setUp(){ 
        
        $this->message = New Message();
    }
    
    // test dzialania konstruktora klasy Message
    public function testIfCreationIsCorrect(){ 
        
        $this->assertEquals(-1, $this->message->getMessageId()); 
        $this->assertEquals(1, $this->message->getReceiverId());
        $this->assertEquals(1, $this->message->getSenderId());    
        $this->assertEquals("", $this->message->getMessageText()); 
        $this->assertEquals("", $this->message->getMessageTitle()); 
        $this->assertEquals("", $this->message->getCreationDate());    
    }  
    
    // testy seterow i getrów
    public function testSetGetMessageText(){  
        
        $this->message->setMessageText("Goodbye bad user"); 
        $this->assertEquals("Goodbye bad user", $this->message->getMessageText());  
    } 
    
    public function testSetGetMessageTitle(){  
        
        $this->message->setMessageTitle("Goodbye"); 
        $this->assertEquals("Goodbye", $this->message->getMessageTitle());  
    } 
    
   
} 

