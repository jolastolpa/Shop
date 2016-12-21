<?php

require_once __DIR__.'/../src/User.php';

class TestUser extends PHPUnit_Framework_TestCase{
    
    private $user;
    
    // inicjuje obiekt klasy User
    protected function setUp() {
        $this->user = new User('Marek', 'Korcz', 'mark.korcz@gmail.com', 'tralala', 'Sezamkowa');
    }
    
    // testy seterow
    public function testIfSetCorrectName(){
        $this->assertEquals('Marek', $this->user->getName());
    }
    
    public function testIfSetCorrectSurname() {
        $this->assertEquals('Korcz', $this->user->getSurname());
    }
    
    public function testIfSetCorrectEmail() {
        $this->assertEquals('mark.korcz@gmail.com', $this->user->getEmail());
    }
    
    public function testIfSetCorrectPassword() {
        $this->assertEquals('tralala', $this->user->getPassword());
    }
    
    public function testIfSetCorrectDeliverAddress() {
        $this->assertEquals('Sezamkowa', $this->user->getDeliverAddress());
    }
    
    // zeruje obiekt klasy User
    protected function tearDown(){
        $this->user = null;
    }
}