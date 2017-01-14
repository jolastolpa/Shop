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
 <div class="col-sm-5 text-center panel panel-success">
                   
                    <h3> To twój panel zarządzający sklepem</h3>