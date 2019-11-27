<?php
header('Content-Type: application/json');
include('includes/db_connect.php');

$query = "SELECT id,quantity FROM product ORDER BY quantity ASC LIMIT 20";
$result = $connect->query($query);

$data = array();
foreach ($result as $row)
{
	$data[] = $row;
}

echo json_encode($data);
?>