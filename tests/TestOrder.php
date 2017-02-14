<?php

require_once __DIR__.'/../src/Order.php';
require_once __DIR__.'/../src/User.php';

class TestOrder extends PHPUnit_Framework_TestCase{
    
    private $user;
    private $order;
    
    // inicjuje obiekt klasy Order
    protected function setUp() {
        
        // inicjuje obiekt klasy User
        $this->user = new User('Bruce', 'Wayne', 'bruce.wayne@gotham.com', 'OhJockerMyLove', 'GothamCity');
        
        // inicjuje obiekt klasy Order
        $this->order = new Order($this->user, 0);
    }
    
    
    // testy seterow
    public function testIfOrderIdIsSet(){
        
        $this->assertEquals(-1, $this->order->getOrderId());
    }
    
    public function testIfOrderOwnerIdIsSet(){
        
        $this->assertEquals(-1, $this->order->getOrderOwnerId());
    }
    
    public function testIfOrderStatusIsSet(){
        
        $this->assertEquals(0, $this->order->getOrderStatus());
    }
    
    public function testIfOrderCreationDateIsSet(){
        
        $this->assertEquals(date("Y-m-d h:i:s"), $this->order->getOrderCreationDate());
    }
    
    
    // zeruje obiekt klasy Order
    protected function tearDown(){
        $this->order = null;
    }
}