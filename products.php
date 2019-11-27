
<?php
include_once '10.10.168.100/includes/db_connect.php';
$sql = "SELECT * FROM product WHERE quantity>0";
$exe = $connect->query($sql);
while($row = $exe->fetch_assoc())
{
    $product = array($row['code'],$row['name'],$row['sp']);
    $image = $row['image'];

    ?>


    <button value="<?php echo $product[0].','.$product[1].','.$product[2]?>" class="col-md-2 product" style="background-color:white;border:1px solid gray;margin-top:8px;margin-right:8px;" id="product">
        <img src="<?="10.10.168.101/$image"?>" alt="<?=$row['name']?>"  width="50px;">
        <small class="text-info"><?=$row['name']?></small><br>(<small><?=$row['item_quantity']?> ml</small>)
        <br>

        <small><?=$row['code']?></small>
    </button>
<?php
}


?>