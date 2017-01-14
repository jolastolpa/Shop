<?php

require_once __DIR__ . '/../src/User.php';

class TestUser_DB extends PHPUnit_Extensions_Database_TestCase {

    protected static $mysqliConn;
    
    private $user;

    public function getConnection() {

        $conn = new PDO(
            $GLOBALS['DB_DSN'], 
            $GLOBALS['DB_USER'], 
            $GLOBALS['DB_PASSWD']
        );

        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    public function getDataSet() {

        return $this->createFlatXmlDataSet(__DIR__ . '/dataset/User.xml');
    }

    // nawiązanie połącznia 
    static public function setUpBeforeClass() {

        self::$mysqliConn = new mysqli(
            $GLOBALS['DB_HOST'], 
            $GLOBALS['DB_USER'], 
            $GLOBALS['DB_PASSWD'], 
            $GLOBALS['DB_NAME']
        );
    }
    
    // inicjuje obiekt klasy User
    protected function setUp(){
        
        $this->user = new User("Mario", "Bros", "mario.bros@nintendo.com", "princess", "castle");
    }

    
    
    // test zapisu z metody saveToDB()
    public function testSaveANewUser() {

        $this->assertTrue($this->user->saveUserToDB(self::$mysqliConn));
    }
    
    // test update'u z metody saveToDB()
    public function testIfUpdateANewUser(){

        $this->user->setSurname('Gonzales');
        $this->user->setDeliverAddress('New Mexico');
        $this->assertTrue($this->user->saveUserToDB(self::$mysqliConn));
    }
    
    // test usuniecia z metody deleteUser()
    public function testIfDeleteANewUser() {

        $this->assertTrue($this->user->deleteUser(self::$mysqliConn));
    }

    // metoda do dataProvider'a metody loadUserById()
    // id i imie z pliku User.xml
    public function getNames(){
        return [
            [1, 'Marek'],
            [2, 'Darek']
        ];
    }
    
    /**
     * @dataProvider getNames
     */
    // test metody loadUserById()
    public function testIfAbleToLoadUserByItsId($id, $name) {

        // test danych z pliku User.xml
        $loadedFirstUser = User::loadUserById(self::$mysqliConn, $id);
        $this->assertEquals($name, $loadedFirstUser->getName());
    }

    
    // test metody loadAllUsers()
    public function testIfReturnsAnArrayOfUsers() {

        $this->assertTrue(is_array(User::loadAllUsers(self::$mysqliConn)));
    }
    
    
    // metoda do dataProvider'a metody loadUserByEmail()
    // email'e z pliku User.xml
    public function getEmails(){
        return [
            ['mark.korcz@gmail.com'],
            ['darek.talarek@gmail.com'],
        ];
    }
    
    /**
     * @dataProvider getEmails
     */
    // test metody loadUserByEmail()
    public function testIfReturnsUserObjectByItsEmail($email) {
        
        // test danych z pliku User.xml
        $loadedFirstUser = User::loadUserByEmail(self::$mysqliConn, $email);
        $this->assertEquals($email, $loadedFirstUser->getEmail());
    }    
    
    
    
    
    // zakończenie połączenia
    static public function tearDownAfterClass(){
        
        self::$mysqliConn = NULL;
    }
    
    protected function tearDown(){
    
        $this->user = NULL;
    }
}
