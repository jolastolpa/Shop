<?php

require_once __DIR__.'/../src/User.php';
require_once __DIR__.'/../src/Product.php';
require_once __DIR__.'/../src/Basket.php';

class TestBasket extends PHPUnit_Framework_TestCase{
    
    protected static $mysqliConn;
    
    private $user;
    private $product;
    private $basket;
    
    public function getConnection(){

        $conn = new PDO(
            $GLOBALS['DB_DSN'], 
            $GLOBALS['DB_USER'], 
            $GLOBALS['DB_PASSWD']
        );

        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    public function getDataSet(){

        return $this->createFlatXmlDataSet(__DIR__ . '/dataset/Basket.xml');
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
    
    // proces inicjacji obiektu klasy Basket
    protected function setUp(){

        parent::setUp();
        
        $this->user = User::loadUserById(self::$mysqliConn, 1);
        $this->product = Product::loadProductById(self::$mysqliConn, 1);
        
        $this->basket = new Basket($this->product, $this->user->getId(), 127);
    }
    
    // testy seterow i geterow
    public function testIfSetCorrectUserId(){
        $this->assertEquals(1, $this->basket->getUserId());
    }
    
    public function testIfSetCorrectProductId(){
        
        $this->assertEquals(1, $this->basket->getProductId());
    }
    
    public function testIfSetCorrectProductAmount(){
        
        $this->assertEquals(127, $this->basket->getProductAmount());
    }

    public function testIfSetCorrectProductPrice(){
        $this->assertEquals(1, $this->basket->getProductPrice());
    }

    public function testIfSetCorrectTotalPrice(){
        
        $this->assertEquals(127, $this->basket->getTotalPrice());
    }

    
    // zakończenie połączenia
    static public function tearDownAfterClass(){
        
        self::$mysqliConn = NULL;
    }
    
    // zeruje obiekty
    protected function tearDown(){
        
        $this->user = null;
        $this->product = null;
        $this->basket = null;
    }
}