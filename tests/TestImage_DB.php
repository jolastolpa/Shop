<?php

require_once __DIR__.'/../src/Image.php';
require_once __DIR__.'/../src/Product.php'; 

class TestImage_DB extends PHPUnit_Extensions_Database_TestCase {
    private $image; 
    private $product;
    
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
        
        return $this->createFlatXmlDataSet(__DIR__.'/dataset/Image.xml');  
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
    public function testSaveAndDeleteANewImage(){ 
      
        
        $image = new Image(); 
        $image->setId(-1);
        $image->setImageLink("Images/1/1.jpg"); 
        $image->setProductId(1); 
        
        // test zapisu
        $this->assertTrue($image->saveToDB(self::$mysqliConn)); 
        
        // test update'u
        $image->setImageLink('Images/1/2.jpg');
        $this->assertTrue($image->saveToDB(self::$mysqliConn));
        
        // test usuniecia
        $this->assertTrue($image->delete(self::$mysqliConn));
    } 
    
    
    public function testIfAbleLoadImageByItsId() {
        
        $loadedImage = Image::loadImageById(self::$mysqliConn, 1); 
        $this->assertEquals('Images/1/1.jpg', $loadedImage->getImageLink());
    }
   
   
    public function testIfAbleToLoadImagesByProductId() {
        $image1 = new Image();
        $image1->setId(1);
        $image1->setImageLink("Images/1/1.jpg");
        $image1->setProductId(1);
        $image1->saveToDB(self::$mysqliConn); 
        
        $image2 = new Image();
        $image2->setId(3);
        $image2->setImageLink("Images/1/2.jpg");
        $image2->setProductId(1);
        $image2->saveToDB(self::$mysqliConn); 
        
        $arrayImagesProductId1[] = $image1;
        $arrayImagesProductId1[] = $image2;
        
        $loadedImagesProduct1 = Image:: loadImagesByProductId(self::$mysqliConn, 1);
        $this->assertEquals($arrayImagesProductId1, $loadedImagesProduct1);
    }
}


