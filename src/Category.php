<?php 

/*
CREATE TABLE Category(
category_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
category_name VARCHAR(50)
)
*/


class Category {
 
    private $category_id;
    private $category_name;

    public function __construct($name = ""){

       $this->category_id = -1;
       $this->setCategoryName($name);
    }  
    

    // setery i getery
    function setCategoryId($newCategoryId){
        
        if(is_int($newCategoryId)){
            $this->category_id = $newCategoryId;
        }
    }

    function setCategoryName($newCategoryName){
        
        if(is_string($newCategoryName) && strlen($newCategoryName) >= 2){
            $this->category_name = $newCategoryName;
        }
    } 

    function getCategoryId(){
        
        return $this->category_id;
    } 
    
    function getCategoryName() {

        return $this->category_name;
     }

     
    
    // operacje na bazie danych
    public function saveToDb(mysqli $conn){ 
        
        if($this->category_id == -1){ 
            
            $sql = "INSERT INTO Category (category_name) VALUES ('$this->category_name')";
            
            $result = $conn->query($sql);
            
            if($result == true){
            
                $this->category_id = $conn->insert_id; 
                return true; 
            }
        }else{  

            $sql = "UPDATE Category SET category_name='$this->category_name' "
                 . "WHERE category_id='$this->category_id'";

            $result = $conn->query($sql);
           
            if($result == true){ 
               
                return true;
            }
        }return false;
    }

    
    public function deleteCategory(mysqli $conn){
        
        if($this->category_id != -1){
        
            $sql = "DELETE FROM Category WHERE category_id = '$this->category_id'";

            $result = $conn->query($sql);

            if($result == true){

                $this->category_id = -1;
                return true;
            }
            return false;
        }
        return true;
    } 

    public static function loadCategoryById(mysqli $conn, $categoryId){
        
        $sql = "SELECT * FROM Category WHERE category_id = '$categoryId'";
       
        $result = $conn->query($sql);
       
        if ($result == true && $result->num_rows == 1){
           
            $row = $result->fetch_assoc();

            $loadedCategory = new Category();
            $loadedCategory->category_id = $row['category_id'];
            $loadedCategory->category_name = $row['category_name'];

            return $loadedCategory;
        }
        return null;
    }



    public static function loadAllCategories(mysqli $conn) {
        
        $sql = "SELECT * FROM Category ORDER BY category_id";
        
        $categories = [];
        
        $result = $conn->query($sql);
        if ($result == true && $result->num_rows > 0){
            
            foreach($result as $row){
                
                $loadedCategory = new Category();
                $loadedCategory->category_id = $row['category_id']; 
                $loadedCategory->category_name = $row['category_name']; 
                
                $categories[] = $loadedCategory;
            }
        }
        return $categories;
    }
}

