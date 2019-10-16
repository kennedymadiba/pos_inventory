<?php
session_start();
include_once '10.10.168.100/includes/db_connect.php';
$barcodeArray=array();
if(isset($_POST['barcodeArray'])){
    $barcodeArray=$_POST['barcodeArray'];
    $_SESSION['barray'] = $barcodeArray;
}
if(isset($_POST['nameArray'])){
    $nameArray=$_POST['nameArray'];
    $_SESSION['narray'] = $nameArray;
}
if(isset($_POST['priceArray'])){
    $priceArray=$_POST['priceArray'];
    $_SESSION['parray'] = $priceArray;
}
if(isset($_POST['quantityArray'])){
    $quantityArray=$_POST['quantityArray'];
    $_SESSION['qarray'] = $quantityArray;
}

$count=count($barcodeArray);

$i=0;

echo "<tbody>";
echo "<thead>
<tr>
    <td>Item</td>
    <td>Unit Price</td>
    <td>Quantity</td>
    <td>Total</td>
</tr>
</thead>";

$subtotal = array();


while($i<$count){

    echo "<tr id='$barcodeArray[$i]'>";
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
    echo "</tr>";
    echo array_sum($quantityArray);
    $i++;
}

echo "</tbody>";
// $productSet=explode(',', $product);
echo "<tfoot>
<br>
<tr>
    <th><br>Total products</th>
    <td><br>(".array_sum($quantityArray)." )</td>  
    <th><br>Net total</th>
    <td><br>".array_sum($subtotal)." ksh</td>
</tr>
</tfoot>

";



?>