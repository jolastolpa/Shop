<?php

session_start();  
require_once __DIR__.'/../config.php'; 
require_once __DIR__.'/../src/Admin.php'; 
require_once __DIR__.'/../src/index.html'; 


    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['email'])  && isset($_POST['password']))  {  
            $email=trim($_POST['email']) ; 
            $password=trim($_POST['password'] );    
        
            $admin_id= Admin::verifyPassword($conn, $email, $password);   
           
              
            if ($admin_id!=-1) { 
            
              $_SESSION['admin_id']=$admin_id; 
              $_SESSION['logged']=true;
              header('location:index.php');   
           
            } else{  
                 $_SESSION['error']='<span style="color:red">Nieprawidlowy login 
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
        <h2><a href="register.php">Rejestracja-gdy nie masz jeszcze konta</a></h2><br><br><br>
 <div class="col-sm-5 text-center panel panel-success">
                     
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

                        <button type="submit" class="bnt btn-group-vertical">Zaloguj</button>
                    </form>
                </div>

            </div>
        </div>


    </body> 
    
</html>