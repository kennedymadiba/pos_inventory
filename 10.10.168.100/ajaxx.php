<?php
include 'includes/db_connect.php';

$category=$_GET['category'];


if($category!=""){
        $query="SELECT * FROM product WHERE category_id='$category'";
         $res=$connect->query($query);
          echo "<select class='form-control' name='product' required>";
           echo "<option value='' selected disabled='true'>select department</option>";
            while($row=mysqli_fetch_array($res)){
                  $code = $row['code'].'|'.$row['item_quantity'];
            echo "<option value='$code'>".$row['name']."(".$row['item_quantity']."ml)</option>";
        }
          echo "</select>";
}
?>