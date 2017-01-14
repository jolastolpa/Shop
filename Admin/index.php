<?php

session_start();  
require_once __DIR__.'/../config.php'; 
require_once __DIR__.'/../src/Admin.php'; 
require_once __DIR__.'/../src/index.html'; 

if(!isset($_SESSION['logged'])) { //zabezpieczenie przed wejsciem z 
    header('Location:log.php');     // wpisujac adres w przegladarce
    exit();  
}  
if(isset($_SESSION['admin_id'])) {  
  $logAdmin=Admin::loadAdminById($conn,$_SESSION['admin_id']);  
  $admin_name=$logAdmin->getAdminName();  
  $adminId=$logAdmin->getAdminId(); 
} 
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Admin Panel</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css" type="text/css" />
    </head>
    <body>
 <div class="col-lg-12 text-center panel panel-success">
      
     <ul class="nav nav-pills nav-justified">
     <li role="presentation" class="active"><a href="index.php">Strona główna</a></li>
     <li role="presentation"><a href="#">Produkty</a> </li>
     <li role="presentation"><a href="#">Kategorie</a></li> 
     <li role="presentation"><a href="#">Zamówienia</a></li> 
     <li role="presentation"><a href="#">Użytkownicy</a></li> 
     <li role="presentation"><a href="#">Wiadomości</a></li> 
     <li role="presentation"><a href="#">Twoje konto</a></li>
     </ul> 
 </div> 
      <h3> <?php echo $admin_name ?> To twój panel zarządzający sklepem</h3> 