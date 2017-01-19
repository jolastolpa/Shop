<?php

session_start();    
require_once __DIR__. '/../config.php'; 
require_once '../src/index.html';
require_once '../src/Admin.php' ; 




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $valid = TRUE; // zakładam prawidłową walidacje
    if (isset($_POST['submit'])) {
        $fields = ['name', 'email', 'password', 'password2'];
        // pobieranie danych : 
        foreach ($fields as $field) {
            $form[$field] = htmlspecialchars(trim($_POST[$field]));
            $error[$field] = ''; // zakładam brak błędów
        }

        if ((strlen($form['name']) < 2) || (strlen($form['name']) > 12 )) {
            $error['name'] = "imię musi mieć od 2do 12 znaków!";
            $valid = false;
        }
        if (filter_var($form['email'], FILTER_VALIDATE_EMAIL) == false) {
            $error['email'] = "wprowadź prawidłowy email!";
            $valid = false;
        }
       // if (Admin::availibilityOfEmail($conn, $form['email']) == false) {
          //  $error['email'] = "przykro mi ten email jest już zajęty!";
           // $valid = false;
       // }
        if ((strlen($form['password']) < 6) || (strlen($form['password']) > 20)) {
            $error['password'] = "hasło musi mieć od 6 do 20 znaków!";
            $valid = false;
        }
        if ($form['password'] != $form['password2']) {
            $error['password2'] = "hasła nie są identyczne!";
            $valid = false;
        }


        if ($valid) {
            $newAdmin = new Admin();
            $newAdmin->setAdminName($form['name']);
            $newAdmin->setAdminEmail($form['email']);
            $newAdmin->setAdminPassword($form['password']);
            $newAdmin->saveAdminToDB($conn);


            if ($newAdmin->saveAdminToDB($conn)) {
                $_SESSION['registersuccess'] = TRUE;
                $_SESSION['newadmin'] = $form['name'];
                header('Location:success.php');
            } else {
                echo "Nie udało sie dodać użytkownika do bazy" . $mysqli->error;
            }
        }
    }
}
?> 
<!DOCTYPE html>
<html>
    <head>
        <title> Zarejestruj się by być adminem</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css" type="text/css" />
    </head>
    <body> 
        <div class="container-fluid"> 
            <div class="row"> 
                <div class="col-md3"></div>
                <div class="col-md-6 text-center panel panel-success">
                    <h3> Zarejestruj się by być adminem</h3> 
                    
                    <form role="form" class="form-horizontal" action=# method="POST" >  
                       
                        <div class="form-group">
                            <label for="name">Imie:</label>
                            <input type="text" class="form-control"  id="name" name="name" value="<?php if(isset($form['name'])) echo $form['name']; //stosowane by dobrze wprowadzone dane nie ginęły gdy pojawi sie jakiś błąd?>"/> 
                            <?php if (isset($error['name'])) echo $error['name']; ?>
                        </div> 
                        
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email"value="<?php if (isset($form['email'])) echo $form['email'];?>"/> 
                            <?php if (isset($error['email'])) echo $error['email']; ?>   
                           
                        </div> 
                        
                        <div class="form-group">
                            <label for="password">Hasło:</label>
                            <input type="password" class="form-control" id="password" name="password"/> 
                             <?php if (isset($error['password'])) echo $error['password']; ?>  
                        </div>  
                        
                        <div class="form-group">
                            <label for="password2">Powtórz hasło:</label>
                            <input type="password" class="form-control" id="password2" name="password2" /> 
                             <?php if (isset($error['password2'])) echo $error['password2']; ?>  
                        </div>

                        <button type="submit" name="submit" class="bnt btn-group-vertical">Zarejestruj</button> 
                        
                    </form>  
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
       


    </body> 
    
</html>

   



