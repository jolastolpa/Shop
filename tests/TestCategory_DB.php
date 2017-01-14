<?php

require_once __DIR__.'/../src/Category.php';

class TestCategory extends PHPUnit_Extensions_Database_TestCase {

    protected static $mysqliConn; 
    
    private $category;

    public function getConnection(){ 
        
        $conn = new PDO(
            $GLOBALS['DB_DSN'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASSWD']
        );
        
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    } 
    
    public function getDataSet(){  
        
        return $this->createFlatXmlDataSet(__DIR__.'/dataset/Category.xml');  
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
    
    // inicjuje obiekt klasy Category
    protected function setUp(){
        
        $this->category = new Category("Furniture");
    }
    
    
    
    // test zapisu metody saveToDB()
    public function testSaveANewCategory(){ 
         
        $this->assertTrue($this->category->saveToDB(self::$mysqliConn)); 
    }
    
    // test update'u metody saveToDB()
    public function testUpdateANewCategory(){ 
    
        $this->category->setCategoryName('PC');
        $this->assertTrue($this->category->saveToDB(self::$mysqliConn));
    }

    // test usuniecia deleteCategory()
    public function testDeleteANewCategory(){
        
        $this->assertTrue($this->category->deleteCategory(self::$mysqliConn));
    } 
    
    public function testIfAbleToLoadCategoryByItsId(){
        
        $loadedCategory = Category::loadCategoryById(self::$mysqliConn, 1); 
        $this->assertEquals('Furniture', $loadedCategory->getCategoryName());
    }
    
     // zakończenie połączenia
    static public function tearDownAfterClass(){
        
        self::$mysqliConn = null;
    }
    
    // zeruje obiekt klasy Category
    protected function tearDown(){
        
        $this->category = null;
    }
}

