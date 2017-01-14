<?php

require_once __DIR__.'/../src/Admin.php';


class TestAdmin_DB extends PHPUnit_Extensions_Database_TestCase{ 
    
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
        
        return $this->createFlatXmlDataSet(__DIR__.'/dataset/Admin.xml');  
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
    
    
    
    // test metody saveToDB() (zapis oraz update) i delete()
    public function testSaveAndDeleteANewAdmin(){
         
        // inicjacja nowego obiektu
        $admin = new Admin('Trinity', 'tuturuttututturuttuttutu', 'trinity.matrix@gmail.com'); 
        
        // test zapisu
        $this->assertTrue($admin->saveToDB(self::$mysqliConn)); 
        
        // test update'u
        $admin->setAdminName('Morpheus');
        $admin->setAdminPassword('RedOrBlue');
        $this->assertTrue($admin->saveToDB(self::$mysqliConn));
        
        // test usuniecia
        $this->assertTrue($admin->delete(self::$mysqliConn));
    }
    
    // test metody loadAdminById()
    public function testIfAbleToLoadAdminByItsId(){ 
         
        // Pierwsze dane z pliku Admin.xml
        $loadedFirstAdmin = Admin::loadAdminById(self::$mysqliConn, 1);
        $this->assertEquals('AgentSmith', $loadedFirstAdmin->getAdminName());
        
        // Drugie dane z pliku Admin.xml
        $loadedSecondAdmin = Admin::loadAdminById(self::$mysqliConn, 2); 
        $this->assertEquals('agent.watson@gmail.com', $loadedSecondAdmin->getAdminEmail());
    }
    
    // test metody loadAdminByEmail()
    public function testIfReturnsAdminObjectByItsEmail() {
        
        // test pierwszych danych z pliku Admin.xml
        $loadedFirstAdmin = Admin::loadAdminByEmail(self::$mysqliConn, 'agent.smith@gmail.com'); 
        $this->assertEquals(1, $loadedFirstAdmin->getAdminId());
        
        // test drugich danych z pliku Admin.xml
        $loadedSecondAdmin = Admin::loadAdminByEmail(self::$mysqliConn, 'agent.watson@gmail.com');
        $this->assertEquals(2, $loadedSecondAdmin->getAdminId());    
    }
    
    public function testIfVerifyIsCorrectAndReturnId() { 
        $id=Admin::verifyPassword(self::$mysqli,'agent.smith@gmail.com', 'tralala'); 
        $this->assertEquals(1,$id);
    }
    
    // zakończenie połączenia
    static public function tearDownAfterClass(){
        self::$mysqliConn = null;
    }
}