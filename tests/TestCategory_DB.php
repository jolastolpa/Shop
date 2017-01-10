<?php

require_once __DIR__.'/../src/Category.php';
require_once __DIR__.'/../src/Product.php'; 

class TestCategory_DB extends PHPUnit_Extensions_Database_TestCase {

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
    public function testSaveNewCategory(){ 
         
        $this->assertTrue($this->category->saveToDB(self::$mysqliConn)); 
    }
    
    // test update'u metody saveToDB()
    public function testUpdateANewCategory(){ 
    
        $this->category->setCategoryName('Clothes');
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
    
    public function testIfLoadedAllCategoriesAreCorrect(){
        
        $category1 = new Category(1, 'Furniture');
        $category2 = new Category(2, 'Clothes');
        
        $category1->saveToDb(self::$mysqliConn);
        $category2->saveToDb(self::$mysqliConn);
        
        $allCategories=[];
        $allCategories[] = $category1;
        $allCategories[] = $category2;
        
        $loadedCategories = Category::loadAllCategories(self::$mysqliConn);
        $this->assertEquals($loadedCategories, $allCategories);
    }
   
    
  
    
    // zeruje obiekt klasy Category
    protected function tearDown(){
        $this->category = null;
    }
}

