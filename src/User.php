<?php

/*
CREATE TABLE User(
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(20),
surname VARCHAR(20),
email VARCHAR(20) UNIQUE,
password VARCHAR(20),
deliver_addr VARCHAR(30)
)
*/

class User{
    
    private $id;
    private $name;
    private $surname;
    private $email;
    private $password;
    private $deliver_addr;
    
    public function __construct($name = "", $surname = "", $email = "", $password = "", $deliver_addr = ""){
        
        $this->id = -1;
        $this->setName($name);
        $this->setSurname($surname);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setDeliverAddress($deliver_addr);
    }
    
    public function setId($id){
        
        if(is_int($id)){
            $this->id = $id;
        }
    }

    public function getId(){
        
        return $this->id;
    }

    public function setName($name){
        
        if(is_string($name) && strlen($name) >= 2){
            $this->name = trim($name);
        }
    }
    
    public function getName(){
        
        return $this->name;
    }
    
    public function setSurname($surname){
        
        if(is_string($surname) && strlen($surname) >= 2){
            $this->surname = trim($surname);
        }
    }
    
    public function getSurname(){
        
        return $this->surname;
    }
    
    public function setEmail($email){
        
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->email = trim($email);
        }
    }
    
    public function getEmail(){
        
        return $this->email;
    }
    
    public function setPassword($password){
        
        if(is_string($password) && strlen($password) >= 5){
            // wersja z hash'owaniem hasla do testow z baza danych
            // $this->password = password_hash(trim($password), PASSWORD_DEFAULT);
            
            // wersja do testow bez bazy danych
            $this->password = trim($password);
        }
    }
    
    public function getPassword(){
        
        return $this->password;
    }
    
    public function setDeliverAddress($address){
        
        if(strlen($address) >= 4){
            $this->deliver_addr = trim($address);
        }
    }
    
    public function getDeliverAddress(){
        
        return $this->deliver_addr;
    }
    
    
    // operacje na bazie danych
    public function saveToDB(mysqli $conn){
        
        if($this->id == -1){
        
            $sql = "INSERT INTO User(name, surname, email, password, deliver_addr)"
                . "VALUES ('$this->name', '$this->surname','$this->email', '$this->password',"
                . "'$this->deliver_addr')";
                    
            $result = $conn->query($sql);
            if($result == true){
                
                $this->id = $conn->insert_id;
                return true;
            } 
        }else{ 
            
            $sql="UPDATE User SET name='$this->name' ,surname='$this->surname',"
                . "email='$this->email', password='$this->password',"
                . "delive_add='$this->deliver_addr' WHERE id='$this->id'";
            
            $result = $conn->query($sql);
            if($result == true){              
                return true;
            }
        }
        return false;
    } 
      
    public function delete(mysqli $conn){
        
        if($this->id != -1){
            
            $sql = "DELETE FROM User WHERE id='$this->id'";
            
            $result = $conn->query($sql);
            if($result == true){
                $this->id = -1;
                return true;
            }
            return false;
        } 
        return true; 
    }
 
    static public function loadUserById(mysqli $conn, $id){
        
        $sql = "SELECT * FROM User WHERE id='$id'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->name = $row['name'];
            $loadedUser->surname = $row['surname'];
            $loadedUser->email = $row['email']; 
            $loadedUser->password = $row['password']; 
            $loadedUser->deliver_addr = $row['deliver_addr'];
            
            return $loadedUser;
        }
        return null; 
    }

    static public function loadAllUsers(mysqli $conn){
        
        $sql = "SELECT * FROM User";
        $ret = [];
        
        $result = $conn->query($sql);
        if($result == true && $result->num_rows != 0){
            
            foreach($result as $row){
                $loadedUser = new Product();
                $loadedUser->id = $row['id'];
                $loadedUser->name = $row['name'];
                $loadedUser->surname = $row['surname'];
                $loadedUser->email = $row['email']; 
                $loadedUser->password = $row['password']; 
                $loadedUser->deliver_adr = $row['deliver_adr'];
                
                $ret[] = $loadedUser;
            }
        }
        return $ret;
    } 
    
    // metoda dedykowana dla admina
    static public function loadUserByEmail(mysqli $conn, $email){
        
        $sql = "SELECT * FROM User WHERE id='$email'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->name = $row['name'];
            $loadedUser->surname = $row['surname'];
            $loadedUser->email = $row['email']; 
            $loadedUser->password = $row['password']; 
            $loadedUser->deliver_addr = $row['deliver_addr'];
            
            return $loadedUser;
        }
        return null; 
    }
}