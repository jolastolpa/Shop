<?php
//require_once __DIR__.'/../vendor/autoload.php';  - mi ta ścieżka nie działa, nie wiem czemu
 require_once '../src/Product.php';


class TestProduct_DB extends PHPUnit_Extensions_Database_TestCase { 
    
    protected static $mysqliConn; 
    public function getConnection() { 
        $conn = new PDO(
            $GLOBALS['DB_DSN'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASSWD']
            ); 
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    } 
    
    public function getDataSet() {  
        
      return  $this->createFlatXmlDataSet(__DIR__.'/dataset/Products.xml');
        
    } 
    public static function setUpBeforeClass() { 
        self::$mysqliConn=new mysqli 
        ($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_NAME']);
    }   
    
     public function testSaveAnewProduct() {  
         // z jakiegos powodu
        $product= new Product(); 
        $product->setName(""); 
        $product->setPrice();  
        $product->setDescription(""); 
        $product->setQuantity();  
        $product->setIdCategory();
        $this->assertTrue($product->saveToDB(self::$mysqliConn));
        
    } 
     
       
     public function testIfIdReturnsProductName() { 
        $loadedProduct=Product::loadProductById(self::$mysqliConn,1); 
        $name= $loadedProduct->getName();
        $this->assertEquals("desk",$name);
    } 
     
  
    
        
    }
