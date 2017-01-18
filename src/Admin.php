<?php

/*
CREATE TABLE Admin(
admin_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
admin_name VARCHAR(50),
admin_pass VARCHAR(70),
admin_email VARCHAR(40) UNIQUE
)
*/

class Admin{
    
    private $admin_id;
    private $admin_name;
    private $admin_pass;
    private $admin_email;
    
    public function __construct($name = "", $pass = "", $email = ""){
        
        $this->admin_id = -1;
        $this->setAdminName($name);
        $this->setAdminPassword($pass);
        $this->setAdminEmail($email);
    }
    
    
    // setery i getery
    public function getAdminId(){
        
        return $this->admin_id;
    }
    
    public function setAdminName($name){
        
        if(is_string($name) && strlen($name) >= 2){
        
            $this->admin_name = trim($name);
        }
    }
    
    public function getAdminName(){
        
        return $this->admin_name;
    }
    
    public function setAdminPassword($pass){
        
        if(is_string($pass) && strlen($pass) >= 5){
            // wersja z hash'owaniem hasla do testow z baza danych
            $this->admin_pass = password_hash(trim($pass), PASSWORD_DEFAULT);
            
            // wersja do testow bez bazy danych
            //$this->admin_pass = trim($pass);
        }
    }
    
    public function getAdminPassword(){
        
        return $this->admin_pass;
    }
    
    public function setAdminEmail($email){
        
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->admin_email = trim($email);
        }
    }
    
    public function getAdminEmail(){
     
        return $this->admin_email;
    }
    
    
    // operacje na bazie danych
    public function saveAdminToDB(mysqli $conn){
        
        if($this->admin_id == -1){
        
            $sql = "INSERT INTO Admin(admin_name, admin_pass, admin_email) "
                 . "VALUES ('$this->admin_name', '$this->admin_pass', '$this->admin_email')";
                    
            $result = $conn->query($sql);
            if($result == true){
                
                $this->admin_id = $conn->insert_id;
                return true;
            } 
        }else{ 
            
            $sql="UPDATE Admin SET admin_name='$this->admin_name', admin_pass='$this->admin_pass', "
               . "admin_email='$this->admin_email' WHERE admin_id='$this->admin_id'";
            
            $result = $conn->query($sql);
            if($result == true){              
                return true;
            }
        }
        return false;
    }
    
    public function deleteAdmin(mysqli $conn){
        
        if($this->admin_id != -1){
            
            $sql = "DELETE FROM Admin WHERE admin_id='$this->admin_id'";
            
            $result = $conn->query($sql);
            if($result == true){
                $this->admin_id = -1;
                return true;
            }
            return false;
        } 
        return true; 
    }
    
    static public function loadAdminById(mysqli $conn, $id){
        
        $sql = "SELECT * FROM Admin WHERE admin_id='$id'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedAdmin = new Admin();
            $loadedAdmin->admin_id = $row['admin_id'];
            $loadedAdmin->admin_name = $row['admin_name'];
            $loadedAdmin->admin_pass = $row['admin_pass'];
            $loadedAdmin->admin_email = $row['admin_email']; 
            
            return $loadedAdmin;
        }
        return null; 
    }
    
    static public function loadAdminByEmail(mysqli $conn, $email){
        
        $sql = "SELECT * FROM Admin WHERE admin_email='$email'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedAdmin = new Admin();
            $loadedAdmin->admin_id = $row['admin_id'];
            $loadedAdmin->admin_name = $row['admin_name'];
            $loadedAdmin->admin_pass = $row['admin_pass'];
            $loadedAdmin->admin_email = $row['admin_email']; 
            
            return $loadedAdmin;
        }
        return null; 
    } 
    
    static public function loadAdminByEmailAndPassword(mysqli $conn, $email, $password){
        
        $sql = "SELECT * FROM Admin WHERE admin_email='$email'";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedAdmin = new Admin();
            $loadedAdmin->admin_id = $row['admin_id'];
            $loadedAdmin->admin_name = $row['admin_name'];
            $loadedAdmin->admin_pass = $row['admin_pass'];
            $loadedAdmin->admin_email = $row['admin_email']; 
            
            if(password_verify($password, $loadedAdmin->getAdminPassword())){
                
                return $loadedAdmin;
            }
        }
        return null; 
    }
}