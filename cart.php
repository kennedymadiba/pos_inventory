
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
}

$count=count($barcodeArray);
$i=0;



echo "<tbody>";
echo "<thead>
<tr>
    <td> Barcode</td>
    <td>Items</td>
    <td>Unit Price</td>
    <td>Quantity</td>
    <td>Total Price</td>
    <td>Delete</td>
</tr>
</thead>";

$subtotal = array();


while($i<$count){

echo "<tr id='$barcodeArray[$i]'>";
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
echo "<button id='removeItem'  class='btn btn-sm btn-danger ' value='$barcodeArray[$i].$quantityArray[$i]'><span class='fa fa-trash'></span></button>";
echo "</td>";
echo "</tr>";
echo array_sum($quantityArray);
$i++;
}

echo "</tbody>";
// $productSet=explode(',', $product);
echo "<tfoot>
<tr>
    <th>Products count (".array_sum($quantityArray)." )</th>
    <th></th>
    <th></th>
    <th></th>
    <th>Net total</th>
    <th>".array_sum($subtotal)." ksh</th>
</tr>

</tfoot>";


?>