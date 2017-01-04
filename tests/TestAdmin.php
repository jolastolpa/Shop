<?php

require_once __DIR__.'/../src/Admin.php';

class TestAdmin extends PHPUnit_Framework_TestCase{
    
    private $admin;
    
    
    // inicjuje obiekt klasy Admin
    protected function setUp() {
        $this->admin = new Admin('Neo', 'paparappapappara', 'neo.matrix@gmail.com');
    }
    
    
    // testy seterow i geterow
    public function testIfSetCorrectAdminId(){
        $this->assertEquals(-1, $this->admin->getAdminId());
    }
    
    public function testIfSetCorrectAdminName(){
        $this->assertEquals('Neo', $this->admin->getAdminName());
    }
    
    public function testIfSetCorrectAdminPassword(){
        $this->assertEquals('paparappapappara', $this->admin->getAdminPassword());
    }
    
    public function testIfSetCorrectAdminEmail(){
        $this->assertEquals('neo.matrix@gmail.com', $this->admin->getAdminEmail());
    }
    
    
    // zeruje obiekt klasy Admin
    protected function tearDown(){
        $this->admin = null;
    }
}