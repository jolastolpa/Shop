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
        $user->setName("Mario"); 
        $user->setSurname('Bros');  
        $user->setEmail('mario.bros@nintendo.com'); 
        $user->setPassword('princess');  
        $user->setDeliverAddress('castle');
        $this->assertTrue($user->saveToDB(self::$mysqliConn));    
    }
       
    public function testIfIdReturnsProductName(){ 
         
        $loadedUser = Product::loadProductById(self::$mysqliConn, 1); 
        $this->assertEquals('Mario', $loadedUser->getName());
    }       
}
