<?php

require_once __DIR__.'/../src/Order.php';
require_once __DIR__.'/../src/User.php';

class TestOrder extends PHPUnit_Framework_TestCase{
    
    private $order;
    private $user;
    private $product;
    
    // inicjuje obiekt klasy Order
    protected function setUp() {
        
        // inicjuje obiekt klasy User oraz tworze zmienna z danymi produktu 
        // poniewaz beda one potrzebne do inicjacji obiektu klasy Order
        $this->user = new User();
        $this->product = ["3" => "5", "7" => "11", "13" => "17"];
        
        // inicjuje obiekt klasy Order
        $this->order = new Order($this->user, 1, $this->product);
    }
    
    
    // testy seterow
    public function testIfOrderIdIsSet() {
        $this->assertEquals(-1, $this->order->getOrderId());
    }
    
    public function testIfOrderOwnerIdIsSet() {
        $this->assertEquals(-1, $this->order->getOrderOwnerId());
    }
    
    public function testIfOrderStatusIsSet() {
        $this->assertEquals(1, $this->order->getOrderStatus());
    }
    
    public function testIfProductIsSet() {
        $this->assertTrue(is_array($this->order->getOrderProduct()));
    }
    
    public function testIfProductCreationDateIsSet() {
        $this->assertEquals(date("Y-m-d h:i:s"), $this->order->getOrderCreationDate());
    }
    
    
    // zeruje obiekt klasy Order
    protected function tearDown(){
        $this->order = null;
    }
}