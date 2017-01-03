<?php

require_once __DIR__.'/../src/Order.php';
require_once __DIR__.'/../src/User.php';


class TestProduct_DB extends PHPUnit_Extensions_Database_TestCase{ 
    
    protected static $mysqliConn; 
    
    private $user;
    private $product;

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
    
    // inicjacja obiektu klasy User i zmiennej produktow
    public function setUp(){
        
        $this->user = new User();
        $this->product = ["3" => "5", "7" => "11", "13" => "17"];
    }
    

    
    // test metody saveToDB() (zapis oraz update) i delete()
    public function testSaveAndDeleteANewOrder(){ 
         
        // inicjacja nowego obiektu
        $order = new Order($this->user, 2, $this->product);

        // test zapisu
        $this->assertTrue($order->saveToDB(self::$mysqliConn)); 
        
        // test update'u
        $order->setOrderStatus(3);
        $this->assertTrue($order->saveToDB(self::$mysqliConn));
        
        // test usuniecia
        $this->assertTrue($order->delete(self::$mysqliConn));
    }
    
    // test metody loadOrderByOrderOwnerId()
    public function testIfAbleToLoadOrderByItsId(){ 
         
        // Pierwsze dane z pliku Order.xml
        $loadedFirstOrder = Order::loadOrderByOrderOwnerId(self::$mysqliConn, 1); 
        $this->assertTrue($loadedFirstOrder);
        $this->assertEquals(10, $loadedFirstOrder->getOrderOwnerId());
        
        // Drugie dane z pliku Order.xml
        $loadedSecondOrder = Order::loadOrderByOrderOwnerId(self::$mysqliConn, 2);
        $this->assertTrue($loadedSecondOrder);
        $this->assertEquals(3, $loadedSecondOrder->getOrderStatus());
    }
    
    // test metody loadOrderByItsOwnId()
    public function testIfReturnsOrderObjectByItsOwnId() {
        
        // test pierwszych danych z pliku Order.xml
        $loadedFirstOrder = Order::loadOrderByItsOwnId(self::$mysqliConn, 1); 
        $this->assertTrue($loadedFirstOrder);
        $this->assertEquals('2017-01-01 11:46:26', $loadedFirstOrder->getOrderCreationDate());

        // test drugich danych z pliku Order.xml
        $loadedSecondOrder = Order::loadOrderByItsOwnId(self::$mysqliConn, 2);
        $this->assertTrue($loadedSecondOrder);
        $this->assertEquals(20, $loadedSecondOrder->getOrderOwnerId()); 
    }
    
    // test metody loadAllOrders()
    public function testIfReturnsAnArrayOfOrders(){
        
        $this->assertTrue(is_array(Order::loadAllOrders(self::$mysqliConn)));
    }
    
    
    
    // wyczyszczenie obiektu i zmiennej z atrybutow
    public function tearDown(){
        
        $this->user = NULL;
        $this->product = NULL;
    }
    
    // zakończenie połączenia
    static public function tearDownAfterClass(){
        self::$mysqliConn = null;
    }
}