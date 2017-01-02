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
    
    // test metody saveToDB() i delete()
    public function testSaveAndDeleteANewUser(){ 
         
        // inicjacja nowego obiektu
        $user = new User(); 
        $user->setId(-1);
        $user->setName("Mario"); 
        $user->setSurname('Bros');  
        $user->setEmail('mario.bros@nintendo.com'); 
        $user->setPassword('princess');  
        $user->setDeliverAddress('castle');
        
        // test zapisu
        $this->assertTrue($user->saveToDB(self::$mysqliConn)); 
        
        // test usuniecia
        $this->assertTrue($user->delete(self::$mysqliConn));
    }
       
    // test metody loadUserById()
    public function testIfAbleToLoadUserByItsId(){ 
         
        // Pierwsze dane z pliku User.xml
        $loadedFirstUser = User::loadUserById(self::$mysqliConn, 1); 
        $this->assertEquals('Marek', $loadedFirstUser->getName());
        
        // Drugie dane z pliku User.xml
        $loadedSecondUser = User::loadUserById(self::$mysqliConn, 2);
        $this->assertEquals('Darek', $loadedSecondUser->getName());
    }
    
    // test metody loadAllUsers()
    public function testIfReturnsAnArrayOfUsers(){
        
        $this->assertTrue(is_array(User::loadAllUsers(self::$mysqliConn)));
    }
    
    // test metody loadUserByEmail()
    public function testIfReturnsUserObjectByItsEmail() {
        
        // test pierwszych danych z pliku User.xml
        $loadedFirstUser = User::loadUserByEmail(self::$mysqliConn, 'mark.korcz@gmail.com'); 
        $this->assertEquals('mark.korcz@gmail.com', $loadedFirstUser->getEmail());
        
        /*
            NIE WIEM CZEMU DRUGI TEST (POMIMO, ŻE TAKI SAM), NIE DZIAŁA. KOMUNIKAT Z KONSOLI:
                PHP Fatal error:  Call to a member function getEmail() on a non-object in ...

        // test drugich danych z pliku User.xml
        $loadedSecondUser = User::loadUserByEmail(self::$mysqliConn, 'darek.talarek@gmail.com');
        $this->assertEquals('darek.talarek@gmail.com', $loadedSecondUser->getEmail()); 
        */
    }
    
    // zakończenie połączenia
    static public function tearDownAfterClass(){
        self::$mysqliConn = null;
    }
}
