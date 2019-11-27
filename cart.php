
<?php
include_once '10.10.168.100/includes/db_connect.php';
$barcodeArray=array();
if(isset($_POST['barcodeArray'])){
    $barcodeArray=$_POST['barcodeArray'];
}
if(isset($_POST['nameArray'])){
    $nameArray=$_POST['nameArray'];
}
if(isset($_POST['priceArray'])){
    $priceArray=$_POST['priceArray'];
}
if(isset($_POST['quantityArray'])){
    $quantityArray=$_POST['quantityArray'];
    if($quantityArray){
        $quantityArray=$quantityArray;
    }
}

$count=count($barcodeArray);
$i=0;


echo "<table class='table table-responsive' id='cart-item-table-header table'>";
echo "<thead>
<tr style='background-color:#ff9f1c;color:white'>
    <th>Barcode</th>
    <th>Items</th>
    <th>Unit Price</th>
    <th>Quantity</th>
    <th>Sub-total</th>
    <th>remove</th>
</tr>
</thead>";

echo "<tbody>";


$subtotal = array();


while($i<$count){

echo "<tr id='$barcodeArray[$i]' style='color:#011627;background-color:white;'>";
echo "<td>";
echo $barcodeArray[$i];
echo "</td>";
echo "<td>";
echo $nameArray[$i];
echo "</td>";
echo "<td>";
echo $priceArray[$i];
echo "</td>";
echo "<td>";
echo "$quantityArray[$i]";
echo "</td>";
echo "<td>";
echo $priceArray[$i]*$quantityArray[$i];
$subtotal[] = $priceArray[$i]*$quantityArray[$i];
echo "</td>";
echo "<td>";
echo "<button style='box-shadow:none;text-align:left' id='removeItem'  class='btn ' value='$barcodeArray[$i].$quantityArray[$i]'><span class='fa fa-trash text-left' style='font-size:13pt;color:#e71d36'></span></button>";
echo "</td>";
echo "</tr>";
array_sum($quantityArray);
$i++;
}

if(isset($quantityArray)){
    $count=array_sum($quantityArray);
}
echo "</tbody>";
// $productSet=explode(',', $product);
echo "<tfoot>
<tr style='background-color:#011627; color:white'>

    <th>Products count (".$count." )</th>
    <th></th>
    <th></th>
    <th></th>
    <th>Net total</th>
    <th>".array_sum($subtotal)." ksh</th>
</tr>


</tfoot>
</table>
<div class='aler' style='border' >
<button style='background-color:#011627;color:white;text-transform:none' type=\"button\" class=\"btn \" data-toggle=\"modal\" data-target=\"#exampleModal\">
  Make sale
</button>
<button style='background-color:#e71d36; color:white;text-transform:none' class='btn'>Cancel</button>
</div>

";



?>