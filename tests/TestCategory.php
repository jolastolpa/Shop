<?php

require_once __DIR__.'/../src/Category.php';


class TestProduct extends PHPUnit_Framework_TestCase{ 
    
    private $category;
    
    // inicjacja obiektu klasy Category
    protected function setUp(){ 
        
        $this->category = New Category("Multimedia");
    }
    
    
    // testy seterow i geterow
    public function testIfSetCorrectCategoryId() {
        $this->assertEquals(-1, $this->category->getCategoryId());
    } 
    
    public function testIfSetCorrectCategoryName(){
        $this->assertEquals('Multimedia', $this->category->getCategoryName());
    }  
    
    
    // zeruje obiekt klasy Category
    protected function tearDown(){
        $this->category = null;
    }
}