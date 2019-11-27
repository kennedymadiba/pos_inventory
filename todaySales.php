<?php
include_once '10.10.168.100/includes/db_connect.php';
$todaySales="SELECT * FROM product";
$r_todaySales=mysqli_query($connect,$todaySales);


$inventory_code=array();
$inventory_name=array();
$inventory_itemQuantity_unit=array();
$inventory_quantity=array();

while($d_todaySales=mysqli_fetch_array($r_todaySales)){
$inventory_code[]=$d_todaySales['code'];
$inventory_name[]=$d_todaySales['name'];
$inventory_itemQuantity_unit[]=$d_todaySales['item_quantity'].$d_todaySales['unit'];
$inventory_quantity[]=$d_todaySales['quantity'];
}

$countInventory=count($inventory_code);
$i=0;

echo '<table class="table table-responsive" style="all:none">';
echo '<thead>';
echo '<tr style="background-color:#ff9f1c;color:white">';
echo '<th>code</th> <th>name</th> <th>per(1unit)</th> <th>units sold</th> <th>remaining</th> <th>Sub total(Ksh)</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
while ($i < $countInventory) {
echo '<tr>';
echo '<td>'.$inventory_code[$i].'</td>';
echo '<td>'.$inventory_name[$i].'</td>';
echo '<td>'.$inventory_itemQuantity_unit[$i].'</td>';

$date=date('Y-m-d');
$i_code=$inventory_code[$i];
$getSold="SELECT SUM(qty),SUM(qty*price) FROM transaction WHERE code='$i_code'AND time='$date'";
$r_getSold=mysqli_query($connect,$getSold);
$d_getSold=mysqli_fetch_array($r_getSold);
echo '<td>'.$d_getSold[0].'</td>';

echo '<td>'.$inventory_quantity[$i].'</td>';
if(isset($d_getSold[1])){
  echo '<td>'.$d_getSold[1].'</td>';
}else{
  echo '<td>'.'0'.'</td>';
}

echo '</tr>';
$i++;
}

$getSales="SELECT SUM(price*qty) FROM transaction WHERE time='$date'";
$r_getSales=mysqli_query($connect,$getSales);
$d_getSales=mysqli_fetch_array($r_getSales);

echo '<tfoot>';
echo '<tr style="background-color:#011627;color:white">';
echo '<th>Total sales today</th>';
echo '<th>'.'Ksh '.$d_getSales[0].'</th>';
echo '<th></th>';
echo '<th></th>';
echo '<th></th>';
echo '<th></th>';
echo '</tr>';
echo '</tfoot>';
echo '</tbody>';
echo '</table>';
?>
