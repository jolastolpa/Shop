<?php

/*
CREATE TABLE `Order`(
order_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
order_owner_id INT NOT NULL,
order_status INT,
order_date DATETIME,
FOREIGN KEY(order_owner_id) REFERENCES User(id)
ON DELETE CASCADE
)
*/

class Order{
    
    private $order_id;
    private $order_owner_id;
    private $order_status;
    private $order_date;
    
    public function __construct(User $user = NULL, $order_status = 0){
        
        $this->order_id = -1;
        $user != NULL ? $this->order_owner_id = $user->getId() : $this->order_owner_id = -1;
        $this->setOrderStatus($order_status);
        $this->order_date = date("Y-m-d h:i:s");
    }
    
    
    // getery i setery
    public function getOrderId(){
        
        return $this->order_id;
    }
    
    public function getOrderOwnerId(){
        
        return $this->order_owner_id;
    }
    
    public function setOrderStatus($status){
        
        // zamowienie oczekujace = 0
        // zamowienie zlozone = 1
        // zamowienie oplacone = 2
        // zamowienie zrealizowane = 3
        if(is_int($status) && $status >= 0 && $status <= 3){
            $this->order_status = $status;
        }
    }
    
    public function getOrderStatus(){
        
        return $this->order_status;
    }
    
    public function setOrderCreationDate(){
        
        $this->order_date = date("Y-m-d h:i:s");
    }
    
    public function getOrderCreationDate(){
        
        return $this->order_date;
    }
    
    
    
    // operacje na bazie danych
    public function saveOrderToDB(mysqli $conn){
        
        if($this->order_id == -1){
            
            $sql = "INSERT INTO `Order`(order_owner_id, order_status, order_date) "
                . "VALUES ('$this->order_owner_id', '$this->order_status', '$this->order_date')";

            $result = $conn->query($sql);
            if($result == true){
                
                $this->order_id = $conn->insert_id;
                return true;
            } 
        }else{ 
            
            $sql="UPDATE `Order` SET order_status='$this->order_status', "
                . "order_date='$this->order_date' WHERE id='$this->order_id'";
            
            $result = $conn->query($sql);
            if($result == true){              
                return true;
            }
        }
        return false;
    } 
      
    public function deleteOrder(mysqli $conn){
        
        if($this->order_id != -1){
            
            $sql = "DELETE FROM `Order` WHERE order_id='$this->order_id'";
            
            $result = $conn->query($sql);
            if($result == true){
                $this->order_id = -1;
                return true;
            }
            return false;
        } 
        return true; 
    }
    
    static public function loadOrderByOrderOwnerId(mysqli $conn, $owner_id){
        
        $sql = "SELECT * FROM `Order` WHERE order_owner_id='$owner_id'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedOrder = new Order();
            $loadedOrder->order_id = $row['order_id'];
            $loadedOrder->order_owner_id = $row['order_owner_id'];
            $loadedOrder->order_status = $row['order_status']; 
            $loadedOrder->order_date = $row['order_date']; 
            
            return $loadedOrder;
        }
        return null; 
    }
    
    static public function loadOrderByItsOwnId(mysqli $conn, $order_id){
        
        $sql = "SELECT * FROM `Order` WHERE order_id='$order_id'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedOrder = new Order();
            $loadedOrder->order_id = $row['order_id'];
            $loadedOrder->order_owner_id = $row['order_owner_id'];
            $loadedOrder->order_status = $row['order_status'];
            $loadedOrder->order_date = $row['order_date']; 
            
            return $loadedOrder;
        }
        return null; 
    }
    
    static public function loadAllOrders(mysqli $conn){
        
        $sql = "SELECT * FROM `Order`";
        $ret = [];
        
        $result = $conn->query($sql);
        if($result == true && $result->num_rows != 0){
            
            foreach($result as $row){
                $loadedOrder = new Order();
                $loadedOrder->order_id = $row['order_id'];
                $loadedOrder->order_owner_id = $row['order_owner_id'];
                $loadedOrder->order_status = $row['order_status'];
                $loadedOrder->order_date = $row['order_date']; 
                
                $ret[] = $loadedOrder;
            }
        }
        return $ret;
    } 
    public function showOrdersForAdmin() { 
        
        echo '<tr><td>'.$this->getOrderId();  
        echo '</td><td>'.$this->getOrderOwnerId(); 
        echo '</td><td>'.$this->getOrderStatus() ; 
        echo '</td><td>'.$this->getOrderCreationDate();  
        echo '</td><td><a href="orders.php?idOrder='.$this->getOrderId().'">Edytuj status</a>';
        echo '</td><td><a href="delete.php?idOrder='.$this->getOrderId().'">Usuń</a>';
        echo '</td><tr>';
    }
}