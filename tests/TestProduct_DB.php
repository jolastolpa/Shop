<?php
//require_once __DIR__.'/../vendor/autoload.php';  - mi ta ścieżka nie działa, nie wiem czemu

require_once __DIR__.'/../src/Product.php';


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
        
        return $this->createFlatXmlDataSet(__DIR__.'/dataset/Product.xml');  
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
    
<<<<<<< HEAD
     public function testSaveAnewProduct() {  
         // z jakiegos powodu
        $product= new Product(); 
        $product->setName(""); 
        $product->setPrice();  
        $product->setDescription(""); 
        $product->setQuantity();  
        $product->setIdCategory();
        $this->assertTrue($product->saveToDB(self::$mysqliConn));
=======
    // test metody saveToDB() i delete()
    public function testSaveAndDeleteANewProduct(){ 
         
        // inicjacja nowego obiektu
        $product = new Product(); 
        $product->setName("name"); 
        $product->setPrice(2);  
        $product->setDescription("text"); 
        $product->setQuantity(3);  
        $product->setIdCategory(1);
>>>>>>> origin/master
        
        // test zapisu
        $this->assertTrue($product->saveToDB(self::$mysqliConn));    
        
        // test usuniecia
        $this->assertTrue($product->delete(self::$mysqliConn));
    }
       
    // test metody loadProductById()
    public function testIfAbleToLoadProductByItsId(){ 
         
        $loadedProduct = Product::loadProductById(self::$mysqliConn,1); 
        $this->assertEquals("desk", $loadedProduct->getName());
    }     
    
    // test metody loadAllProducts()
    public function testIfReturnsAnArrayOfProducts(){
        
        $this->assertTrue(is_array(Product::loadAllProducts(self::$mysqliConn)));
    }
    
    // zakończenie połączenia
    static public function tearDownAfterClass(){
        self::$mysqliConn = null;
    }
}
