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
}