<?php

class Status { 
     private $id ; 
     private $name; 
     
     
     public function __construct($id = -1, $name=null) {
        $this->id = $id;
        $this->setName($name);
    
        
    } 
    
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    
    public function setId($NewId) {
        $this->id = $NewId;
    }
    public function setName($NewName) {
        $this->name = $NewName;
    }
    
    public function saveToDb(mysqli $conn) { 
        
        if($this->id == -1){
        
        $sql = "INSERT INTO Statuses(id, name)"
                . "VALUES ($this->id, '$this->name')";
                    
            $result = $conn->query($sql);
            if($result == true){
                
                $this->id = $conn->insert_id;
                return true;
            } 
        }else{ 
            
            $sql="UPDATE Statuses SET name='$this->name' WHERE id='$this->id'";
            
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
        
        $sql = "SELECT * FROM Statuses WHERE id=$id";
        
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            
            $row = $result->fetch_assoc();
            $loadedStatus = new Status();
            $loadedStatus->id = $row['id'];
            $loadedStatus->name = $row['name'];
          
            return $loadedStatus;
        }
        return null; 
    }

    static public function loadAllStatuses(mysqli $conn){
        
        $sql = "SELECT * FROM Statuses";
        $ret = [];
        
        $result = $conn->query($sql);
        if($result == true && $result->num_rows != 0){
            
            foreach($result as $row){
                $loadedStatus = new Status();
                $loadedStatus->id = $row['id'];
                $loadedStatus->name = $row['name'];
               
                
                $ret[] = $loadedStatus;
            }
        }
        return $ret;
    }    
} 


