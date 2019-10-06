<?php
if(isset($_POST['product'])){
    $product=$_POST['product'];
}
$productSet=explode(',', $product);
echo "<tr>";
echo "<td>";
echo $productSet[0];
echo "</td>";
echo "<td>";
echo $productSet[1];
echo "</td>";
echo "<td>";
echo $productSet[2];
echo "</td>";
echo "<td>";
echo 1;
echo "</td>";
echo "<td>";
echo 1;
echo "</td>";
echo "</tr>";
?>