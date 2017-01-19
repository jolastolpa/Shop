<?php

session_start();  
require_once __DIR__.'/../config.php'; 
require_once __DIR__.'/../src/Admin.php'; 
require_once __DIR__.'/../src/index.html'; 

if(!isset($_SESSION['logged'])) { //zabezpieczenie przed wejsciem z 
    header('Location:log.php');     // wpisujac adres w przegladarce
    exit();  
}  
if(isset($_SESSION['adminId'])) {  
  $logAdmin=Admin::loadAdminById($conn,$_SESSION['adminId']);  
  $adminName=$logAdmin->getAdminName();
  
} 
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Admin Panel</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css" type="text/css" /> 
          <?php require_once __DIR__ . '/nav.php' ?>
    </head>
    <body>  
        <div class="col-lg-12 text-center "> <br><br><br>
           <h3> <?php echo  $adminName?> To twój panel zarządzający sklepem</h3>
        </div>
        
   </body>
