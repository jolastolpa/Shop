<?php

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
 
     public function addNewCategory(mysqli $conn) {
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
 
     public static function loadAllProductFromCategory(mysqli $conn, $categoryId) { 
         // to zpaytanie jeszcze nie wiem czy poprawne 
         $sql = "SELECT * FROM Products
                JOIN Categories ON Products.categoryId = Categories.categoryId
                WHERE Categories.categoryId = '$categoryId'";
        
         $result = $conn->query($sql); 
         $ret=[];
         if ($result == true && $result->num_rows > 0) {
             foreach ($result as $row) {
                 $loadedProduct = new Product();
                 $loadedProduct->productId = $row['id'];
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

