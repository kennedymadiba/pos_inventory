<?php
include_once '10.10.168.100/includes/db_connect.php';
if(isset($_POST['code'])){
    $barcode=$_POST['code'];
    $query="SELECT quantity FROM product WHERE code='$barcode' ";
    $run=mysqli_query($connect,$query);
    $disp=mysqli_fetch_array($run);
    echo $disp['quantity'];
}
?>