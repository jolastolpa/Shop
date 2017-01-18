<?php

session_start();  
require_once __DIR__.'/../config.php'; 
require_once __DIR__.'/../src/Admin.php'; 
require_once __DIR__.'/../src/index.html'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if( $loadedAdmin= Admin::loadAdminByEmailAndPassword($conn, $email, $password)){

            $_SESSION['adminId']=$loadedAdmin->getAdminId(); 
            $_SESSION['adminName']=$loadedAdmin->getAdminName(); 
            $_SESSION['logged'] = true;
            header('location:index.php');
        } else {
            $_SESSION['error'] = '<span style="color:red">Nieprawidlowy login 
                    lub hasło !</span>';
            header('Location:log.php');
        }
    }
}


$conn->close();
?> 

<!DOCTYPE html>
<html>
    <head>
        <title> Admin Panel - Login</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css" type="text/css" />
    </head>
    <body>  
        <div class="container-fluid">
           <div class="row">   
                   <div class=" col-md-4"></div>
                   <div class=" col-md-4 text-center"> <h2><a href="register.php" >Rejestracja     <span class="glyphicon glyphicon-pencil "></span></a><br><br><br><br></div>
                   <div class=" col-md-4"></div>
            </div>
            <div class="row">  
                    <div class="col-md-3"></div>
                    <div class="col-md-6 panel panel-success text-center"> 
                        <h3> Zaloguj się adminie</h3> 
                            <form action=# method="POST"> 
                                
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="email">
                                </div> 
                                
                                <div class="form-group">
                                    <label for="password">Hasło:</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="hasło">
                                </div>

                                <button type="submit" class="bnt btn-info btn-lg">Zaloguj</button> 
                                
                            </form>
                    </div> 
                    <div class="col-md-3"></div>

                </div>
        
        </div>

    </body> 
    
</html>