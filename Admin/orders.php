<?php

require_once __DIR__.'/require_once.php'; 
 
if (!isset($_SESSION['logged'])) {
    header('Location:log.php');
    exit();

} ?>
<!DOCTYPE html>
<html>
    <head>
        <title> Zamówienia</title>

    <?php  include __DIR__ . '/nav.php' ?><br><br>
    
    <body> 
        <?php
        if (isset($_GET['idOrder'])) {
            $orderToModify = Order::loadOrderByItsOwnId($conn, $_GET['idOrder']); 
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($_POST['status'] > 0) {

                    $orderToModify->setOrderStatus($_POST['status']); 
                    $orderToModify->saveOrderToDB($conn); 
                    header('Location:orders.php');
                }
            }
                echo '<div class="col-lg-4 text-left  ">';
                echo '<form role="form" method="POST" action="#"> ';
                echo '<div class="form-group">';
                echo'<select class="form-control" id="status" name="status">';
                echo'<option value="0">Wybierz status</option> ';

                $allStatuses = Status::loadAllStatuses($conn);
                foreach ($allStatuses as $status) {
                    echo "<option value='" . $status->getStatusId() . "'>" . $status->getStatusName() . "</option>";
                }
                echo '</select>';
                echo ' <input class="btn btn-success" type="submit" value="Zmień status" name="submit"><br>'; 
                echo '</div>';
                echo '</form>';
                echo '</div><br><br> '; 
            
        }
        ?>
        
        <div class="col-lg-10 text-left  ">   
            <h3>Wszystkie zamówienia:<h3> 
             <?php
                    displayOrders(); 
                    $loadedOrders=Order::loadAllOrders($conn); 
                        
                        foreach($loadedOrders as $order){
                           $order->showOrdersForAdmin();
                        } ?>
        </div>

