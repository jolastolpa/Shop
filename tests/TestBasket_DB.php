<?php

require_once __DIR__.'/../src/User.php';
require_once __DIR__.'/../src/Product.php';
require_once __DIR__.'/../src/Basket.php';

class TestBasket_DB extends PHPUnit_Extensions_Database_TestCase {

    protected static $mysqliConn;
    
    private $user;
    private $product;
    private $basket;

    public function getConnection() {

        $conn = new PDO(
            $GLOBALS['DB_DSN'], 
            $GLOBALS['DB_USER'], 
            $GLOBALS['DB_PASSWD']
        );

        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    public function getDataSet() {

        return $this->createFlatXmlDataSet(__DIR__ . '/dataset/Basket.xml');
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
        
        parent::setUp();
        
        $this->user = User::loadUserById(self::$mysqliConn, 1);
        $this->product = Product::loadProductById(self::$mysqliConn, 1);
        
        $this->basket = new Basket($this->product, $this->user->getId(), 127);
    }

    
    
    
    // test zapisu z metody saveToDB()
    public function testSaveANewProductInBasket() {

        $this->assertTrue($this->basket->saveToDB(self::$mysqliConn));
    }
    
    // test update'u z metody saveToDB()
    public function testIfUpdateANewProductAmount(){

        $this->basket->setProductAmount(527);
        $this->assertTrue($this->basket->saveToDB(self::$mysqliConn));
    }
    
    // test usuniecia z metody delete()
    public function testIfDeleteANewProductFromBasket(){

        $this->assertTrue($this->basket->delete(self::$mysqliConn));
    }

    // test metody loadOneProductInBasketById()
    public function testIfAbleToLoadProductInBasketById(){

        // test danych z pliku Basket.xml
        $loadedProduct = Basket::loadOneProductInBasketById(self::$mysqliConn, 1);
        $this->assertEquals(10, $loadedProduct->getProductAmount());
    }
    
    // test metody loadAllProductsInBasketByUserId()
    public function testIfReturnsAnArrayOfProductsInBasket(){

        // test danych z pliku Basket.xml
        $this->assertTrue(is_array(Basket::loadAllProductsInBasketByUserId(self::$mysqliConn, 1)));
    }
    
    
    
    // zakończenie połączenia
    static public function tearDownAfterClass(){
        self::$mysqliConn = NULL;
    }
    
    protected function tearDown(){
        $this->user = NULL;
    }
}
