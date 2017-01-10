<?php
//require_once __DIR__.'/../vendor/autoload.php';  - mi ta ścieżka nie działa, nie wiem czemu
require_once __DIR__.'/../src/Product.php';
class TestProduct_DB extends PHPUnit_Extensions_Database_TestCase{ 
    
    protected static $mysqliConn; 
    
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
        
        return $this->createFlatXmlDataSet(__DIR__.'/dataset/Product.xml');  
    } 
    
    // inicjacja obiektu
    public function setUp(){
        
        $this->product = new Product('kasza', 5, 'manna', 100, 2); 
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
    public function testSaveAndDeleteANewProduct(){ 
        
        // test zapisu
        $this->assertTrue($this->product->saveToDB(self::$mysqliConn)); 
        
        // test update'u
        $this->product->setPrice(30);
        $this->product->setQuantity(111);
        $this->assertTrue($this->product->saveToDB(self::$mysqliConn));
        
        // test usuniecia
        $this->assertTrue($this->product->delete(self::$mysqliConn));
    }
       
    // test metody loadProductById()
    public function testIfAbleToLoadProductByItsId(){ 
         
        $loadedProduct = Product::loadProductById(self::$mysqliConn, 1); 
        $this->assertEquals("desk", $loadedProduct->getName());
    }     
    
    // test metody loadAllProducts()
    public function testIfReturnsAnArrayOfProducts(){
        
        $this->assertTrue(is_array(Product::loadAllProducts(self::$mysqliConn)));
    } 
    
    
      public function testIfAbleToLoadProductsByCategoryId(){
        
        $product1 = new Product();
        $product1->setId(4);
        $product1->setName('stool');
        $product1->setPrice(999.99);
        $product1->setDescription('new');
        $product1->setQuantity(6);
        $product1->setProductCategoryId(1);
        $product1->saveToDB(self::$mysqliConn); 
        
        $product2 = new Product();
        $product2->setId(5);
        $product2->setName('sofa');
        $product2->setPrice(19.99);
        $product2->setDescription('new');
        $product2->setQuantity(7);
        $product2->setProductCategoryId(1);
        $product2->saveToDB(self::$mysqliConn); 
        
        $arrayProductsCategoryId1[] = $product1;
        $arrayProductsCategoryId1[] = $product2;
        
        $loadedProductsCategory1 = Category::loadAllProductFromCategory(self::$mysqliConn, 1);
        $this->assertSame($arrayProductsCategoryId1, $loadedProductsCategory1);
    }
    
    
    // zerowanie obiektu
    public function tearDown(){
        
        $this->product = null;
    }
    
    // zakończenie połączenia
    static public function tearDownAfterClass(){
        
        self::$mysqliConn = null;
    }
}



