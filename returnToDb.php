<?php
include_once '10.10.168.100/includes/db_connect.php';
if(isset($_POST['barcode'])){
    $barcode=$_POST['barcode'];
}
if(isset($_POST['quantity'])){
    $quantity=$_POST['quantity'];
}

$queryToUpdateInventory="UPDATE product SET quantity=quantity+$quantity WHERE code='$barcode' ";
mysqli_query($connect,$queryToUpdateInventory);
?>