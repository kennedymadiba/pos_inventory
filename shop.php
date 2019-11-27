
<?php
include_once '10.10.168.100/includes/db_connect.php';
$sql = "SELECT * FROM product WHERE quantity>0";
$exe = $connect->query($sql);
while($row = $exe->fetch_assoc())
{
    $product = array($row['code'],$row['name'],$row['sp']);
    $image = $row['image'];

    ?>


    <button value="<?php echo $product[0].','.$product[1].','.$product[2]?>" class="col-md-3 col-sm-2 col-xs-2 product "  id="product" style="background-color:white; box-shadow:none;border-radius:0%">
        <img src="<?="10.10.168.101/$image"?>" alt="<?=$row['name']?>"  width="50px;">
        <small style="color:#011627" class=""><?=$row['name']?></small><br>(<small><?=$row['item_quantity']?> ml</small>)
        <br>

        <small><?=$row['code']?></small>
    </button>
<?php
}


?>