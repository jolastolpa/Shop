<?php

class Status{ 
    
    private $status_id ; 
    private $status_name; 
     
     
    public function __construct($id = -1, $name = ""){
        
        $this->setStatusId($id);
        $this->setStatusName($name);   
    } 
    
    
    // getery
    public function getStatusId(){
        
        return $this->status_id;
    }
    
    public function getStatusName(){
    
        return $this->status_name;
    }
    
    // setery
    public function setStatusId($newId){
        
        if(is_int($newId)){
            $this->status_id = $newId;
        }
    }
    
    public function setStatusName($newName){
        
        if(is_string($newName) && strlen($newName) >= 2){
            $this->status_name = trim($newName);
        }
    }
    
    
    // operacje na bazie danych
    public function saveToDb(mysqli $conn) { 
        
        if($this->id == -1){
        
            $sql = "INSERT INTO Status(status_id, status_name)"
                 . "VALUES ('$this->status_id', '$this->status_name')";
                    
            $result = $conn->query($sql);
            if($result == true){
                
                $this->status_id = $conn->insert_id;
                return true;
            } 
        }else{ 
            
            $sql="UPDATE Status SET name='$this->status_name' WHERE status_id='$this->status_id'";
            
            $result = $conn->query($sql);
            if($result == true){              
                return true;
            }
        }
        return false;
    } 
      
    public function delete(mysqli $conn){
        
        if($this->id != -1){
            
            $sql = "DELETE FROM Statuses WHERE id='$this->id'";
            
            $result = $conn->query($sql);
            if($result == true){
                $this->id = -1;
                return true;
            }
            return false;
        } 
        return true; 
    }  
    
    static public function loadStatusById(mysqli $conn, $id){
        
        $sql = "SELECT * FROM Status WHERE status_id=$id";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedStatus = new Status();
            $loadedStatus->status_id = $row['status_id'];
            $loadedStatus->status_name = $row['status_name'];
          
            return $loadedStatus;
        }
        return null; 
    }

    static public function loadAllStatuses(mysqli $conn){
        
        $sql = "SELECT * FROM Status";
        $ret = [];
        
        $result = $conn->query($sql);
        if($result == true && $result->num_rows != 0){
            
            foreach($result as $row){
                $loadedStatus = new Status();
                $loadedStatus->status_id = $row['status_id'];
                $loadedStatus->status_name = $row['status_name'];
                
                $ret[] = $loadedStatus;
            }
        }
        return $ret;
    }    
} 


