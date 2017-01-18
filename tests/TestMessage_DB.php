<?php

require_once __DIR__.'/../src/Message.php';
class TestMessage_DB extends PHPUnit_Extensions_Database_TestCase{ 
    
    protected static $mysqliConn; 
    
    private $message;
    
    public function getConnection(){ 
        
        $conn = new PDO(
            $GLOBALS['DB_DSN'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASSWD']
        );
        
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    } 
    
    public function getDataSet(){  
        
        return $this->createFlatXmlDataSet(__DIR__.'/dataset/Message.xml');  
    } 
    
    // inicjacja obiektu
    public function setUp(){
        
        $this->message = new Message(1,1,"welcome","new user","11-01-2017"); 
    }
    
    // nawiązanie połącznia 
    static public function setUpBeforeClass(){ 
        
        self::$mysqliConn = new mysqli(
            $GLOBALS['DB_HOST'], 
            $GLOBALS['DB_USER'], 
            $GLOBALS['DB_PASSWD'], 
            $GLOBALS['DB_NAME']
        );
    }   

    // test metody saveToDB() 
    public function testSaveANewMessage(){ 
        
        // test zapisu
        $this->assertTrue($this->message->saveToDB(self::$mysqliConn)); 
        
        // bez update - wysłanej juz wiadomosci nie zmieniamy
     
    } 
    
    
    // test metody loadMessageById
    public function testIfAbleToLoadMessageByItsId(){ 
         
        $loadedMessage = Message::loadMessageById(self::$mysqliConn, 4); 
        $this->assertEquals("welcome", $loadedMessage->getMessageText());
    }     
    
    // test metody loadMessagesByReceiverId
    public function testIfAbleToLoadMessagesByReceiverId(){
        
        $this->assertTrue(is_array(Message::loadMessagesByReceiverId(self::$mysqliConn,1)));
    } 
     // test metody loadMessagesBySenderId
    public function testIfAbleToLoadMessagesBySenderId(){
        
        $this->assertTrue(is_array(Message::loadMessagesBySenderId(self::$mysqliConn,1)));
    } 
    
    // zerowanie obiektu
    public function tearDown(){
        
        $this->product = null;
    }
    
    // zakończenie połączenia
    static public function tearDownAfterClass(){
        
        self::$mysqliConn = null;
    } 
    
}


