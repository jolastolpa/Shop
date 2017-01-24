<?php


require_once __DIR__ . '/require_once.php';

if (!isset($_SESSION['logged'])) {
    header('Location:log.php');
    exit();
}
if (isset($_GET['idUser'])) {
    $idReceiver = ($_GET['idUser']);
}
if (isset($_SESSION['adminId'])) {
    $idSender = ($_SESSION['adminId']);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errorStart = '<span style="color:red">';
    $errorEnd = "</span>";
    $error = '';
    $valid = true;

    if ((strlen(trim($_POST['title'])) < 1) || (strlen(trim($_POST['title'])) > 100 )) {
        $error['name'] = $errorStart . "Tytuł wiadomości może mieć od 1 do 100 znaków!" . $errorEnd;
        $valid = false;
    }

    if ((strlen(trim($_POST['text'])) < 1) || (strlen(trim($_POST['text'])) > 500 )) {
        $error['name'] = $errorStart . "Text wiadomości może mieć od 1 do 500 znaków!" . $errorEnd;
        $valid = false;
    }
    if ($valid) {
        $creationDate = date("Y-m-d H:i:s");
        $newMessage = new Message();
        $newMessage->setReceiverId($idReceiver);
        $newMessage->setSenderId($idSender);
        $newMessage->setMessageTitle($_POST['title']);
        $newMessage->setMessageTitle($_POST['text']);
        $newMessage->setCreationDate($creationDate);
        $newMessage->saveToDB($conn);

        if ($newMessage->saveToDB($conn)) {
            $_SESSION['send'] = "Wysłano wiadomość";
        } else {
            echo $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Wyświj wiadomość</title>

    <?php include __DIR__ . '/nav.php' ?><br><br><br><br>
    
    <body>  
        <ol class="breadcrumb">
           <li><a href="index.php">Home</a></li>
           <li><a href="users.php">Użytkownicy</a></li>
           <li class="active">Wyślij wiadomość</li>
        </ol><br> 
         <?php  
             if(isset($_SESSION['send'])) { 
                echo $_SESSION['send'] ;
             }  
             ?>  
        <form method='POST'><br> 
            <div class="col-sm-8 text-left panel panel-success "> 
                
                <div class="form-group">
                     <label for="title">Tytuł wiadomości</label>
                     <input type="text" class="form-control"  id="title" name="title"/> 
                            <?php if (isset($error['title'])) {echo $error['title']; } ?>
                </div> <br><br>
                
                <div class="form-group">
                    <label for="text">Treść wiadomości</label>
                    <textarea class="form-control" rows="3" name="text"></textarea> 
                </div> <br> 
                    <input class="btn btn-success" type="submit" value="Wyślij wiadomość" name="submit">  
            </div>
        </form>
