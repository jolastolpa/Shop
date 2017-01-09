<?php

require_once __DIR__ . '/../src/User.php';

class TestUser_DB extends PHPUnit_Extensions_Database_TestCase {

    protected static $mysqliConn;

    public function getConnection() {

        $conn = new PDO(
                $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']
        );

        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    public function getDataSet() {

        return $this->createFlatXmlDataSet(__DIR__ . '/dataset/User.xml');
    }

    // nawiązanie połącznia 
    static public function setUpBeforeClass() {

        self::$mysqliConn = new mysqli(
                $GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_NAME']
        );
    }

    // test metody saveToDB() (zapis oraz update) i delete()
    public function testSaveAndDeleteANewUser() {

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

        // test update'u
        $user->setSurname('Gonzales');
        $user->setDeliverAddress('New Mexico');
        $this->assertTrue($user->saveToDB(self::$mysqliConn));

        // test usuniecia
        $this->assertTrue($user->delete(self::$mysqliConn));
    }

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
    static public function tearDownAfterClass() {
        self::$mysqliConn = null;
    }

}
