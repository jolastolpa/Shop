<?php

require_once __DIR__.'/../src/User.php';


class TestProduct_DB extends PHPUnit_Extensions_Database_TestCase{ 
    
    protected static $mysqliConn; 
    
    public function getConnection(){ 
        
        $conn = new PDO(
            $GLOBALS['DB_DSN'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASSWD']
        );
        
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    } 
    
    public function getDataSet(){  
        
        return $this->createFlatXmlDataSet(__DIR__.'/dataset/User.xml');  
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
    
    public function testSaveANewUser(){ 
         
        $user = new User(); 
        $user->setId(-1);
        $user->setName("Mario"); 
        $user->setSurname('Bros');  
        $user->setEmail('mario.bros@nintendo.com'); 
        $user->setPassword('princess');  
        $user->setDeliverAddress('castle');
        $this->assertTrue($user->saveToDB(self::$mysqliConn));    
    }
       
    public function testIfIdReturnsUserName(){ 
         
        // Pierwsze dane z pliku User.xml
        $loadedFirstUser = User::loadUserById(self::$mysqliConn, 1); 
        $this->assertEquals('Marek', $loadedFirstUser->getName());
        
        // Drugie dane z pliku User.xml
        $loadedSecondUser = User::loadUserById(self::$mysqliConn, 2);
        $this->assertEquals('Darek', $loadedSecondUser->getName());
    }       
    
    // zakończenie połączenia
    static public function tearDownAfterClass(){
        self::$mysqliConn = null;
    }
}
