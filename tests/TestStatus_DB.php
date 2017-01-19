<?php

require_once __DIR__.'/../src/Status.php';
class TestStatus_DB extends PHPUnit_Extensions_Database_TestCase{ 
    
    protected static $mysqliConn; 
    
    private $status;
    
    public function getConnection(){ 
        
        $conn = new PDO(
            $GLOBALS['DB_DSN'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASSWD']
        );
        
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    } 
    
    public function getDataSet(){  
        
        return $this->createFlatXmlDataSet(__DIR__.'/dataset/Status.xml');  
    } 
    
    // inicjacja obiektu
    public function setUp(){
        
        parent::setUp();
        $this->status = new Status('waiting'); 
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

    // test zapisu z metody saveToDB()
    public function testSaveANewStatus(){ 
        
        $this->assertTrue($this->status->saveToDB(self::$mysqliConn)); 
    } 
    
    // test update'u z metody saveToDB()
    public function testUpdateANewStatus(){ 
        
        $this->status->setStatusName("signed");
        $this->assertTrue($this->status->saveToDB(self::$mysqliConn));
    }
    
    // test usunięcia z metody delete()
    public function testDeleteANewStatus(){ 

        $this->assertTrue($this->status->delete(self::$mysqliConn));
    }
       
    // test metody loadStatusById()
    public function testIfAbleToLoadStatusByItsId(){ 
         
        $loadedStatus = Status::loadStatusById(self::$mysqliConn, 1); 
        $this->assertEquals("unconfirmed", $loadedStatus->getStatusName());
    }     
    
    // test metody loadAllStatuses()
    public function testIfReturnsAnArrayOfStatuses(){
        
        $this->assertTrue(is_array(Status::loadAllStatuses(self::$mysqliConn)));
    }
    
    
    // zerowanie obiektu
    public function tearDown(){
        
        $this->status = null;
    }
    
    // zakończenie połączenia
    static public function tearDownAfterClass(){
        
        self::$mysqliConn = null;
    }
}


