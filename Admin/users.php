<?php
require_once __DIR__.'/require_once.php'; 
 
if (!isset($_SESSION['logged'])) {
    header('Location:log.php');
    exit();
}   
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Użytkownicy</title>

    <?php  include __DIR__ . '/nav.php' ?><br><br><br><br>
    
    <body> 
        
        <div class="col-lg-12 text-left  ">   
            <h3>Użytkownicy sklepu: <h3> 
             <?php
                    displayUsers(); 
                    $loadedUsers=User::loadAllUsers($conn);
                        foreach($loadedUsers as $user){
                           $user->showUsersForAdmin();
                        } ?>
        </div>

