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
 
CREATE TABLE `Item_Order`(
item_order_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
order_id INT NOT NULL,
product_id INT NOT NULL,
product_amount INT,
FOREIGN KEY(order_id) REFERENCES `Order`(order_id)
ON DELETE CASCADE,
FOREIGN KEY(product_id) REFERENCES Product(id)
ON DELETE CASCADE
)
*/

require_once 'User.php';
require_once 'Product.php';

class Order{
    
    // zmienne do tabeli `Order`
    private $order_id;
    private $order_owner_id;
    private $order_status;
    private $order_date;
    
    
    public function __construct(User $user = NULL, $order_status = 0){
        
        // automatycznie inicjalizowane id podczas zapisu do tabeli `Order`
        $this->order_id = -1;
        
        // zmienne do zapisu w tabeli `Order`
        $user != NULL ? $this->order_owner_id = $user->getId() : $this->order_owner_id = -1;
        $this->setOrderStatus($order_status);
        $this->setOrderCreationDate();
    }
    
    
    
    
    // setery
    public function setOrderStatus($status){
        
        // zamowienie zlozone = 1
        // zamowienie oplacone = 2
        // zamowienie zrealizowane = 3
        if(is_int($status) && $status >= 0 && $status <= 3){
            $this->order_status = $status;
        }else{
            $this->order_status = NULL;
        }
    }
    
    public function setOrderCreationDate(){
        
        $this->order_date = date("Y-m-d h:i:s");
    }
    
    public function setProductAmount($amount){
        
        if(is_int($amount) && $amount >= 1){
            $this->product_amount = $amount;
        }else{
            $this->product_amount = NULL;
        }
    }
    
    
    
    
    // getery
    public function getOrderId(){
        
        return $this->order_id;
    }
    
    public function getOrderOwnerId(){
        
        return $this->order_owner_id;
    }
    
    public function getOrderStatus(){
        
        return $this->order_status;
    }
    
    public function getOrderCreationDate(){
        
        return $this->order_date;
    }   
    
    
    
    
    /*
        metody dla tabeli `Order`
    */
    
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
            
            $sql="UPDATE `Order` SET order_status='$this->order_status' WHERE order_id='$this->order_id'";
            
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
               
    public function showOrdersForAdmin(){ 
        
        echo '<tr><td>'.$this->getOrderId();  
        echo '</td><td>'.$this->getOrderOwnerId(); 
        echo '</td><td>'.$this->getOrderStatus() ; 
        echo '</td><td>'.$this->getOrderCreationDate();  
        echo '</td><td><a href="orders.php?idOrder='.$this->getOrderId().'">Edytuj status</a>';
        echo '</td><td><a href="delete.php?idOrder='.$this->getOrderId().'">Usuń</a>';
        echo '</td><tr>';
    }
    
    static public function loadOrderByOrderOwnerId(mysqli $conn, $ownerId){
        
        $sql = "SELECT * FROM `Order` WHERE order_owner_id='$ownerId'";
        
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
    
    static public function loadOrderByItsOwnId(mysqli $conn, $orderId){
        
        $sql = "SELECT * FROM `Order` WHERE order_id='$orderId'";
        
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
    
    
    
    
    /*
        metody dla tabeli `Item_Order`
    */
    
    // metoda użyta w addItemOrder(). Status zero zamowienia jest potrzebny do 
    // dodawania produktow do koszyka 
    static public function provideThatUsersOrderWithStatusZeroIsCreated(mysqli $conn, $userId) {
               
        $order = Order::loadOrderByOrderOwnerId($conn, $userId);
        
        if($order){
            
            return $order->getOrderId();
        }else{
            
            $user = User::loadUserById($conn, $userId);
            
            $order = new Order($user, 0);
            $order->saveOrderToDB($conn);
            
            if($order->getOrderId() > 0){
                return $order->getOrderId();
            }
        }
        return false;
    }
    
    static public function addItemOrder(mysqli $conn, $userId, $productId, $productAmount){

        $orderId = Order::provideThatUsersOrderWithStatusZeroIsCreated($conn, $userId);

        $sql = "INSERT INTO `Item_Order`(order_id, product_id, product_amount) ".
               "VALUES ('$orderId', '$productId', '$productAmount')";
        
        $result = $conn->query($sql);
        
        if($result == true){

            return true;
        }
        return false;
    }

    
    static public function updateItemOrder(mysqli $conn, $itemOrderId, $productAmount){
        
        if($itemOrderId > 0){
            
            $sql = "UPDATE `Item_Order` SET product_amount='$productAmount' ".
                   "WHERE item_order_id='$itemOrderId'";

            $result = $conn->query($sql);
            if($result == true){

                return true;
            }
            return false;
        } 
        return true; 
    }
    
    static public function deleteItemOrder(mysqli $conn, $itemOrderId){
        
        if($itemOrderId > 0){
            
            $sql = "DELETE FROM `Item_Order` WHERE item_order_id='$itemOrderId'";
            
            $result = $conn->query($sql);
            if($result == true){

                return true;
            }
        }
        return false;
    }   
    
    static public function loadItemOrdersByOrderId(mysqli $conn, $orderId){
        
        $sql = "SELECT * FROM `Item_Order` WHERE order_id='$orderId'";
        
        $arr = [];
        
        $result = $conn->query($sql); 
        if($result == true && $result->num_rows > 0){
            
            foreach($result as $row){
                
                $product = Product::loadProductById($conn, $row['product_id']);
                $productPrice = $product->getPrice();
                
                $arr[] = [
                    "item_order_id"       => (int)$row['item_order_id'],
                    "order_id"            => (int)$row['order_id'],
                    "product_id"          => (int)$row['product_id'],
                    "product_amount"      => (int)$row['product_amount'],
                    "product_total_price" => $productPrice * $row['product_amount']
                ];
            }         
            return $arr;
        }
        return null; 
    }
}