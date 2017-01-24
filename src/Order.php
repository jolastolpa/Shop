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
item_order_id NOT NULL PRIMARY KEY AUTO_INCREMENT,
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
    
    // zmienne do tabeli `Item_Order`
    private $item_order_id;
    // $order_id - id zamowienia potrzebne do identyfikacji z `Order` (jest zapisywana w `Item_Order`).
    private $product_id;
    private $product_amount;
    // getTotalPrice - zwraca sume z mnozenia ilosci produktu * jego ceny
    
    
    
    
    public function __construct(User $user = NULL, $order_status = 0, Product $product = NULL, $product_amount = 0){
        
        // automatycznie inicjalizowane id podczas zapisu do tabeli `Order`
        $this->order_id = -1;
        
        // zmienne do zapisu w tabeli `Order`
        $user != NULL ? $this->order_owner_id = $user->getId() : $this->order_owner_id = -1;
        $this->setOrderStatus($order_status);
        $this->setOrderCreationDate();
        
        
        // automatycznie inicjalizowane id podczas zapisu do tabeli `Item_Order`
        $this->item_order_id = -1;
        
        // zmienne do zapisu w tabeli `Item_Order`
        $product != NULL ? $this->product_id = $product->getId() : $this->product_id = -1;
        $this->setProductAmount($product_amount);
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
    
    public function getItemOrderId(){
        
        return $this->item_order_id;
    }
    
    public function getProductId(){
        
        return $this->product_id;
    }
    
    public function getOrderStatus(){
        
        return $this->order_status;
    }
    
    public function getOrderCreationDate(){
        
        return $this->order_date;
    }
    
    public function getProductAmount(){
        
        return $this->product_amount;
    }
    
    // geter obliczajacy łączną cene danego produktu w zamwówieniu.
    // sumy nie przypisuje do żadnej zmiennej żeby nie marnować miejsca w DB
    public function getTotalPrice(){
        
        // tworze nowe połączenie
        $conn = new mysqli('localhost', 'root', 'CodersLab', 'Shop_Test');

        if($conn->connect_error){
            die("Polaczenie nieudane. Blad: " . $conn->connect_error."<br>");
        }
        
        // inicjuje obiekt klasy Produkt by wyciagnac z niego cene produktu
        $p = Product::loadProductById($conn, $this->product_id);

        return $this->product_amount * $p->getPrice();
    }
    
    
    
    
    // operacje na tabeli `Order`
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
            $loadedOrder->item_order_id = NULL;
            $loadedOrder->product_id = NULL;
            $loadedOrder->product_amount = NULL;
            
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
            $loadedOrder->item_order_id = NULL;
            $loadedOrder->product_id = NULL;
            $loadedOrder->product_amount = NULL;
            
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
                $loadedOrder->item_order_id = NULL;
                $loadedOrder->product_id = NULL;
                $loadedOrder->product_amount = NULL;
                
                $ret[] = $loadedOrder;
            }
        }
        return $ret;
    }    
    
    
    
    
    // operacje na tabeli `Item_Order`
    public function saveItemOrderToDB(mysqli $conn){
        
        if($this->item_order_id == -1){
            
            $sql = "INSERT INTO `Item_Order`(order_id, product_id, product_amount) "
                . "VALUES ('$this->order_id', '$this->product_id', '$this->product_amount')";

            $result = $conn->query($sql);
            if($result == true){
                
                $this->item_order_id = $conn->insert_id;
                return true;
            } 
        }
        return false;
    }
    
    public function deleteItemOrder(mysqli $conn){
        
        if($this->item_order_id != -1){
            
            $sql = "DELETE FROM `Item_Order` WHERE item_order_id='$this->item_order_id'";
            
            $result = $conn->query($sql);
            if($result == true){
                $this->item_order_id = -1;
                return true;
            }
            return false;
        } 
        return true; 
    }
    
    static public function loadItemOrderByOrderId(mysqli $conn, $order_id){
        
        $sql = "SELECT * FROM `Item_Order` WHERE order_id='$order_id'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedItemOrder = new Order();
            $loadedItemOrder->order_id = NULL;
            $loadedItemOrder->order_owner_id = NULL;
            $loadedItemOrder->order_status = NULL; 
            $loadedItemOrder->order_date = NULL; 
            $loadedItemOrder->item_order_id = $row['item_order_id'];
            $loadedItemOrder->product_id = $row['product_id'];
            $loadedItemOrder->product_amount = $row['product_amount'];
            
            return $loadedItemOrder;
        }
        return null; 
    }
}