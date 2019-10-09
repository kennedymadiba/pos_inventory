<?php
include_once '10.10.168.100/includes/db_connect.php';
if(isset($_POST['reduceInventory'])){
    $barcode=$_POST['reduceInventory'];
}

$reduceDbInventory="UPDATE product SET quantity=quantity-1 WHERE code='$barcode' ";
mysqli_query($connect,$reduceDbInventory);
?>