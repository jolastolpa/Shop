<?php

session_start();   
require_once __DIR__. '/../config.php'; 
require_once '../src/index.html';
require_once '../src/Admin.php' ; 

if(!isset($_SESSION['registersuccess'])) { // zabezpieczenie gdyby ktos wpisal 
    header('Location:index.php');          // witam.php do przegladarki bez rejestracji
    exit(); 
} else { 
    unset($_SESSION['registersuccess']);
  } 
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Udana rejestracja</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css" type="text/css" />
    </head>

<body> 
     <div class="col-lg-6 text-center "> 
         <p> Gratulujemy <strong> <?php  echo $_SESSION['newadmin'] ;  ?> </strong> rejestracji jako nowy admin!
             <span class="glyphicon glyphicon-arrow-right "></span>
             <a href="log.php">Zaloguj się na swoje konto</p>
                  
     </div>
           
    
    
    
</body> 
</html>
