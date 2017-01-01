<?php

/*
CREATE TABLE Order(
order_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
order_owner_id INT NOT NULL,
order_status INT,
order_product VARCHAR(1000),
order_date DATE,
FOREIGN KEY(order_owner_id) REFERENCES User(id)
ON DELETE CASCADE
)
*/

class Order{
    
    private $order_id;
    private $order_owner_id;
    private $order_status;
    private $order_product;
    private $order_date;
    
    public function __construct(User $user = NULL, $order_status = 0, $order_product = ""){
        
        $this->setId(-1);
        $user != NULL ? $this->order_owner_id = $user->getId() : $this->order_owner_id = -1;
        $this->setOrderStatus($order_status);
        $this->setOrderProduct($order_product);
        $this->order_date = date("Y-m-d h:i:s");
    }

    
    public function setOrderId($id){
        
        if(is_int($id)){
            $this->order_id = $id;
        }
    }

    public function getOrderId(){
        
        return $this->order_id;
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
    
    public function setOrderProduct($product){
        
        // sprawdzam czy podana zmienna jest tablica o strukturze ['id produktu' => 'ilosc produktu']
        if(is_array($product) && !is_numeric($product) && !is_string($product)){
            $this->order_product = $product;
        }else{
            
            // jesli nie jest to nie przypisuje nic!
            $this->order_product = "";
        }
    }
    
    public function getOrderProduct(){
        
        return $this->order_product;
    }
    
    // metoda wyswietlajaca kod w html
    public function displayProductAsHTML(){
        
        foreach ($this->getProduct() as $key => $value){
            
            // miejsce na kod wyswietlajacy produkty w html
        }
        
        // awaryjna/tymczasowa wartosc zwracana przez niedokonczona metode
        return true;
    }
    
    
    // operacje na bazie danych
    public function saveToDB(mysqli $conn){
        
        if($this->order_id == -1){
        
            // przed zapisem serializuje 'order_product' i przypisuje do zmiennej
            $serializedProduct = serialize($this->order_product);            
            
            $sql = "INSERT INTO Order(order_id, order_owner_id, order_status, order_product, order_date)"
                . "VALUES ('$this->order_id', '$this->order_owner_id', '$this->order_status',"
                . " , '$serializedProduct', '$this->order_date')";
                    
            $result = $conn->query($sql);
            if($result == true){
                
                $this->order_id = $conn->insert_id;
                return true;
            } 
        }else{ 
            
            // przed updatem serializuje 'order_product' i ustawiam nowa date
            $serializedProduct = serialize($this->order_product); 
            $date = date("Y-m-d h:i:s");
            
            $sql="UPDATE Order SET order_status='$this->order_status' ,order_product='$serializedProduct',"
                . "date='$date' WHERE id='$this->order_id'";
            
            $result = $conn->query($sql);
            if($result == true){              
                return true;
            }
        }
        return false;
    } 
      
    public function delete(mysqli $conn){
        
        if($this->order_id != -1){
            
            $sql = "DELETE FROM Order WHERE order_id='$this->order_id'";
            
            $result = $conn->query($sql);
            if($result == true){
                $this->order_id = -1;
                return true;
            }
            return false;
        } 
        return true; 
    }
    
    // metoda dedykowana dla admina
    static public function loadOrderByUserId(mysqli $conn, $id){
        
        $sql = "SELECT * FROM Order WHERE order_owner_id='$id'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedOrder = new Order();
            $loadedOrder->order_id = $row['order_id'];
            $loadedOrder->order_owner_id = $row['order_owner_id'];
            $loadedOrder->order_status = $row['order_status'];
            $loadedOrder->order_product = unserialize($row['order_product']); 
            $loadedOrder->order_date = $row['order_date']; 
            
            return $loadedOrder;
        }
        return null; 
    }
    
    static public function loadOrderById(mysqli $conn, $id){
        
        $sql = "SELECT * FROM Order WHERE order_id='$id'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedOrder = new Order();
            $loadedOrder->order_id = $row['order_id'];
            $loadedOrder->order_owner_id = $row['order_owner_id'];
            $loadedOrder->order_status = $row['order_status'];
            $loadedOrder->order_product = unserialize($row['order_product']); 
            $loadedOrder->order_date = $row['order_date']; 
            
            return $loadedOrder;
        }
        return null; 
    }
    
    // metoda dedykowana dla admina
    static public function loadAllOrders(mysqli $conn){
        
        $sql = "SELECT * FROM Order";
        $ret = [];
        
        $result = $conn->query($sql);
        if($result == true && $result->num_rows != 0){
            
            foreach($result as $row){
                $loadedOrder = new Order();
                $loadedOrder->order_id = $row['order_id'];
                $loadedOrder->order_owner_id = $row['order_owner_id'];
                $loadedOrder->order_status = $row['order_status'];
                $loadedOrder->order_product = unserialize($row['order_product']); 
                $loadedOrder->order_date = $row['order_date']; 
                
                $ret[] = $loadedOrder;
            }
        }
        return $ret;
    } 
    
}