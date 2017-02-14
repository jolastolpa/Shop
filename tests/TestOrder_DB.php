<?php

require_once __DIR__.'/../src/Order.php';
require_once __DIR__.'/../src/User.php';
require_once __DIR__.'/../src/Product.php';


class TestProduct_DB extends PHPUnit_Extensions_Database_TestCase{ 
    
    protected static $mysqliConn; 
    
    private $user;
    private $order;

    public function getConnection(){ 
        
        $conn = new PDO(
            $GLOBALS['DB_DSN'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASSWD']
        );
        
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    } 
    
    public function getDataSet(){  
        
        return $this->createFlatXmlDataSet(__DIR__.'/dataset/Order.xml');  
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
    
    // inicjacja obiektu klasy User oraz obiektu klasu Order
    public function setUp(){
        
        // przywrócenie defaultowego działania metody getDataSet()
        parent::setUp();
        
        // inicjacja i zapis obiektu klasy user
        $this->user = new User('Bruce', 'Wayne', 'bruce.wayne@gotham.com', 'OhJockerMyLove', 'GothamCity');
        $this->user->saveUserToDB(self::$mysqliConn);

        $this->order = new Order($this->user, 2);
    }
    
    /*
        testy dla tabeli Order
    */
    
    // test zapisu z metody saveOrderToDB()
    public function testSaveANewOrder(){ 
        
        $this->assertTrue($this->order->saveOrderToDB(self::$mysqliConn)); 
    }

    // test update'u z metody saveOrderToDB()
    public function testUpdateANewOrder(){ 
        
        $this->order->setOrderStatus(3);
        $this->assertTrue($this->order->saveOrderToDB(self::$mysqliConn));
    }
        
    // test usuniecia z metody deleteOrder()
    public function testDeleteANewOrder(){ 
        
        $this->assertTrue($this->order->deleteOrder(self::$mysqliConn));
    }

    // test metody loadOrderByOrderOwnerId()
    public function testIfAbleToLoadOrderByOrderOwnerId(){ 
         
        // Pierwsze dane z pliku Order.xml
        $loadedFirstOrder = Order::loadOrderByOrderOwnerId(self::$mysqliConn, 10); 
        $this->assertEquals(1, $loadedFirstOrder->getOrderId());
        
        // Drugie dane z pliku Order.xml
        $loadedSecondOrder = Order::loadOrderByOrderOwnerId(self::$mysqliConn, 20);
        $this->assertEquals(3, $loadedSecondOrder->getOrderStatus());
    }

    // test metody loadOrderByItsOwnId()
    public function testIfAbleToLoadOrderByItsOwnId(){
        
        // test pierwszych danych z pliku Order.xml
        $loadedFirstOrder = Order::loadOrderByItsOwnId(self::$mysqliConn, 1); 
        $this->assertEquals('2017-01-01 11:46:26', $loadedFirstOrder->getOrderCreationDate());

        // test drugich danych z pliku Order.xml
        $loadedSecondOrder = Order::loadOrderByItsOwnId(self::$mysqliConn, 2);
        $this->assertEquals(20, $loadedSecondOrder->getOrderOwnerId()); 
    }

    // test metody loadAllOrders()
    public function testIfReturnsAnArrayOfOrders(){
        
        $this->assertTrue(is_array(Order::loadAllOrders(self::$mysqliConn)));
    }
    
    
    
    
    /*
        testy dla tabeli Item_Order
    */
    
    // chwilowy brak czasu na ich napisanie....
    
    
    
    // wyczyszczenie obiektów
    public function tearDown(){
        
        // zerowanie obiektu klasy User
        $this->user = NULL;
        
        // zerowanie obiektu klasy Order
        $this->order = NULL;
    }
    
    // zakończenie połączenia
    static public function tearDownAfterClass(){
        
        self::$mysqliConn = null;
    }
}