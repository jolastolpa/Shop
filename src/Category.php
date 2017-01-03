<?php 


/*
CREATE TABLE Category(
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(20),

*/



class Category {
 
     public $categoryId;
     public $categoryName;
 
     public function __construct($categoryId = -1, $categoryName = null) {
         $this->categoryId = $categoryId;
         $this->setCategoryName($categoryName);
     }  
     
     function setCategoryId($categoryId) {
         $this->categorId = $categoryId;
     }
     
     function setCategoryName($categoryName) {
         $this->categoryName = $categoryName;
     } 
     
     function getCategoryId() {
         return $this->categoryId;
     } 
     function getCategoryName() {
           
          return $this->categoryName;
      }
 
     public function saveToDb(mysqli $conn) {
         $sql = "INSERT INTO Categories (category_name) VALUES ('$this->categoryName')";
         $result = $conn->query($sql);
         if ($result == true) {
             return true;
         } else {
             return false;
         }
     }
 
     public static function deleteCategory(mysqli $conn, $categotyId) {
         $sql = "DELETE FROM Categories WHERE category_id = $categotyId)";
         $result = $conn->query($sql);
         if ($result == true) {
             return true;
         } else {
             return false;
         }
     } 
     
     public static function loadCategoryById(mysqli $conn, $categoryId) {
        $sql="SELECT * FROM Categories WHERE category_id = $categoryId";
        $result=$conn->query($sql);
        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedCategory = new Category();
            $loadedCategory->categoryId=$row['category_id'];
            $loadedCategory->categoryName=$row['category_name'];
            return $loadedCategory;
        }
    }

 
     public static function loadAllProductFromCategory(mysqli $conn, $categoryId) { 
         // to zpaytanie jeszcze nie wiem czy poprawne 
         $sql = "SELECT * FROM Products JOIN Categories ON Products.categoryId = Categories.categoryId
               WHERE Categories.category_id = $categoryId";
        
         $result = $conn->query($sql); 
         $ret=[];
         if ($result == true && $result->num_rows > 0) {
             foreach ($result as $row) {
                 $loadedProduct = new Product();
                 $loadedProduct->id = $row['id'];
                 $loadedProduct->name = $row['name'];
                 $loadedProduct->description = $row['description'];
                 $loadedProduct->categoryId = $categoryId;
                 $loadedProduct->price = $row['price'];
                 $loadedProduct->quantity = $row['quantity'];
                 
                 
                 $ret[]=$loadedProduct;
 
                    
             
             return $ret;
             }
         } 
     }
  
      public static function getAllCategories(mysqli $connection) {
          $sql = "SELECT * FROM Categories ORDER BY category_id";
          $categories = [];
          $result = $connection->query($sql);
          if ($result == true && $result->num_rows > 0) 

          
          return $categories;
      }
 
     
  
    
 
     
 
     
 
 }

