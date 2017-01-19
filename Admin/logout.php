<?php
session_start();

unset($_SESSION['logged']); 
unset($_SESSION['adminId']);
 
    header('Location:log.php');   
     

