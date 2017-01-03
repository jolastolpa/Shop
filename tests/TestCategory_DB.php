<?php

require_once __DIR__.'/../src/Category.php';
require_once __DIR__.'/../src/Product.php'; 

class TestCategory extends PHPUnit_Extensions_Database_TestCase {

    
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
    
    // test metody saveToDB() (zapis oraz update) i delete()
    public function testSaveAndDeleteANewCategory(){ 
         
        // inicjacja nowego obiektu
        $category = new Category(); 
        $category->setId(-1);
        $category->setName("Furniture"); 
       
        
        // test zapisu
        $this->assertTrue($category->saveToDB(self::$mysqliConn)); 
        
        // test update'u
        $category->setName('Clothes');
        $this->assertTrue($user->saveToDB(self::$mysqliConn));
        
        // test usuniecia
        $this->assertTrue($category->deleteCategory(self::$mysqliConn));
    } 
    
    public function testIfAbleLoadCategoryByItsId() {
        
        $loadedCategory = Category::loadCategoryById(self::$mysqliConn, 1); 
        $this->assertEquals('Furniture', $loadedCategory->getCategoryName());
    }
    public function testIfLoadedAllCategoriesAreCorrect() {
        $category1 = new Category(1, 'Furniture');
        $category2 = new Category(2, 'Clothes');
        $category1->saveToDb(self::$mysqliConn);
        $category2->saveToDb(self::$mysqliConn);
        $allCategories=[];
        $allCategories[] = $category1;
        $allCategories[] = $category2;
        $loadedCategories = Category::getAllCategories(self::$mysqliConn);
        $this->assertEquals($loadedCategories, $allCategories);
    }
   
    public function testIfAbleToLoadProductsByCategoryId() {
        $product1 = new Product();
        $product1->setId(4);
        $product1->setCategoryId(1);
        $product1->setName('stool');
        $product1->setDescription('new');
        $product1->setPrice(999.99);
        $product1->setQuantity(6);
        $product1->saveToDB(self::$mysqliConn); 
        
        $product2 = new Product();
        $product2->setProductId(5);
        $product2->setCategoryId(1);
        $product2->setName('sofa');
        $product2->setDescription('new');
        $product2->setPrice(19.99);
        $product2->setQuantity(7);
        $product2->saveToDB(self::$mysqliConn); 
        
        $arrayProductsCategoryId1[] = $product1;
        $arrayProductsCategoryId1[] = $product2;
        
        $loadedProductsCategory1 = Category::loadAllProductFromCategory(self::$mysqliConn, 1);
        $this->assertEquals($arrayProductsCategoryId1, $loadedProductsCategory1);
    }
}

