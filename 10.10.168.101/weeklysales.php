<?php
header('Content-Type: application/json');
include('includes/db_connect.php');
date_default_timezone_set('Africa/Nairobi');

$today = date("Y-m-d");
$week = date('Y-m-d', strtotime('-7 days'));
$query = "SELECT transaction.code,SUM(transaction.qty) as qty,product.id FROM transaction INNER JOIN product ON transaction.code = product.code WHERE transaction.time BETWEEN '$week' AND '$today' GROUP BY transaction.code";
$result = $connect->query($query);

$data = array();
foreach ($result as $row)
{
	$data[] = $row;
}

echo json_encode($data)
?>