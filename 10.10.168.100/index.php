<?php 
session_start();

include('includes/db_connect.php');
if(!isset($_SESSION['admin_id']))
{
	header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <?php include('plugins/style.php');?>
	<title>POS + INVENTORY SYSTEM</title>
</head>
<body>
<?php include('plugins/nav.php');?>

<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<h3 class="text-dark mt-2">Point of Sale and Inventory System</h3>
			<hr>
		</div>

	</div>
 
   <div class="row">
   	<div class="col-md-4">
	 <h3 class="text-info text-center">Current Stock</h3>
	 <table class="table table-hover">
	 	<thead>
		    <tr>
		     <th>Category</th>
		     <th>Product Name</th>
		     <th>Remaining Stock</th>
		     </tr>
		  </thead>
		  <tbody>
		  	<tr>
		  	 <td>Beer</td>
		  	 <td>Tusker</td>
		  	 <td>140</td>
		  	</tr>
		  	<tr>
		  	 <td>Beer</td>
		  	 <td>Guiness</td>
		  	 <td>100</td>
		  	</tr>
		  	<tr>
		  	 <td>Whisky</td>
		  	 <td>Captain Morgan</td>
		  	 <td>80</td>
		  	</tr>
		  	<tr>
		  	 <td>Whisky</td>
		  	 <td>Jameson</td>
		  	 <td>100</td>
		  	</tr>
		  	<tr>
		  	 <td>Whisky</td>
		  	 <td>Jameson</td>
		  	 <td>100</td>
		  	</tr>
		  	<tr>
		  	 <td>Whisky</td>
		  	 <td>Jameson</td>
		  	 <td>100</td>
		  	</tr>
		  </tbody>
	 </table>
	</div>
	<div class="col-md-7 offset-md-1">
	   <h3 class="text-info text-center">List of Current Sales</h3>
	   <table class="table table-hover">
	   	<thead>
		    <tr>
		     <th>Date</th>
		     <th>Product Name</th>
		     <th>Product Code</th>
		     <th>Quantity</th>
		     <th>Price each(ksh)</th>
		     <th>Total Price(ksh)</th>
		     <th>Profit(ksh)</th>
		     </tr>
		  </thead>
		  <tbody>
           <tr>
           	<td>2019-10-05 12:27</td>
           	<td>Jameson</td>
           	<td>123467854</td>
           	<td>8</td>
           	<td>2500</td>
           	<td>20000</td>
           	<td>8000</td>
           </tr>
           <tr>
           	<td>2019-10-05 12:27</td>
           	<td>Jameson</td>
           	<td>123467854</td>
           	<td>8</td>
           	<td>2500</td>
           	<td>20000</td>
           	<td>8000</td>
           </tr>
           <tr>
           	<td>2019-10-05 12:27</td>
           	<td>Jameson</td>
           	<td>123467854</td>
           	<td>8</td>
           	<td>2500</td>
           	<td>20000</td>
           	<td>8000</td>
           </tr>
           <tr>
           	<td>2019-10-05 12:27</td>
           	<td>Jameson</td>
           	<td>123467854</td>
           	<td>8</td>
           	<td>2500</td>
           	<td>20000</td>
           	<td>8000</td>
           </tr>
		  </tbody>
	   </table>
	</div>
   </div>

</div>


<?php include('plugins/js.php');?>
</body>
</html>