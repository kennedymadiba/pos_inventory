<?php 
session_start();

include('includes/db_connect.php');
include('includes/config.php');
date_default_timezone_set('Africa/Nairobi');
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
	<title>POS - TODAY'S SALES RECORDS</title>

	<style type="text/css">
		.blink{
		width:auto;
		height: auto;
	    /*background-color: magenta;*/
		/*padding: 5px;	*/
		/*text-align: center;*/
		/*line-height: 50px;*/
	}
	.spans{
		font-size: 18px;
		font-family: cursive;
		color: red;
		animation: blink 1s linear infinite;
	}
	@keyframes blink{
	0%{opacity: 0;}
	25%{opacity: .25;}
	50%{opacity: .5;}
	75%{opacity: .75;}
	100%{opacity: 1;}
	}
	</style>
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
   	<div class="col-md-5">
	 <h3 class="text-info text-center">Current Stock</h3>
	 <table class="table table-hover" id="tbl_currentstock">
	 	<thead>
		    <tr>
		     <th>Category</th>
		     <th>Product Name</th>
		     <th>Remaining Stock</th>
		     </tr>
		  </thead>
		  <tbody>
		  	<?php
              $db->orderBy("quantity","asc");
			  $results = $db->get('product');

			  foreach ($results as $row) 
			  {
			  	$catid=$row['category_id'];
			  	$db->where("category_id",$catid);
			  	$one = $db->getOne ("category");
			  	$catname = $one['name'];
			  ?>
             <tr>
		  	 <td><?=$catname?></td>
		  	 <td><?=$row['name']." (".$row['item_quantity']."ml)"?></td>
		  	 <td><?php
                 if($row['quantity']<=10){
                 	echo "<div class='blink'><span class='spans'>".$row['quantity']."</span></div>";
                 }else{
                 	echo $row['quantity'];
                 }
		  	 ?></td>
		  	</tr>
			  <?php
			  }
		  	?>
		  	
		  </tbody>
	 </table>
	</div>
	<div class="col-md-6 offset-md-1">
	   <h3 class="text-info text-center">List of Today Sales</h3>
	   <table class="table table-hover" id="todaysales">
	   	<thead>
		    <tr>
		     <!-- <th>Date</th> -->
		     <th>Code</th>
		     <th>Name</th>
		     <th>Quantity</th>
		     <th>S.P (ksh)</th>
		     <th>Total Price(ksh)</th>
		     <th>Profit(ksh)</th>
		     </tr>
		  </thead>
		  <tbody>
		  <?php
		    $today = date("Y-m-d");
            $query = "SELECT transaction.code,transaction.time,transaction.qty,transaction.price,product.name,product.bp FROM transaction INNER JOIN product ON transaction.code = product.code AND transaction.time = '$today' ORDER BY transaction.id DESC";
            $result = $connect->query($query);
            $totalprice = 0;
            $bprice = 0;
            while ($row = $result->fetch_assoc())
            {
             $totalbp = $row['qty']*$row['bp'];
             $totalsp = $row['qty']*$row['price'];
             $totalprice += $totalsp;
             $bprice += $totalbp;
            ?>
            <tr>
           	<!-- <td><?=$row['time']?></td> -->
           	<td><?=$row['code']?></td>
           	<td><?=$row['name']?></td>
           	<td><?=$row['qty']?></td>
           	<td><?=number_format($row['price'])?></td>
           	<td><?php
             echo number_format($row['qty']*$row['price']);
           	?></td>
           	<td><?php
             echo number_format($totalsp-$totalbp);
           	?></td>
           </tr>

            <?php
            }
		  ?>
		  <tr>
		  	<td><b>TOTAL</b></td>
		  	<td><?php echo ""; ?></td>
		  	<td><?php echo ""; ?></td>
		  	<td><?php echo ""; ?></td>
            <td><b><?=number_format($totalprice)?></b></td>
            <td><b><?=number_format($totalprice-$bprice)?></b></td>
		  </tr>
         </tbody>
	   </table>
	</div>
   </div>

</div>


<?php include('plugins/js.php');?>
<?php include('plugins/datatablejs.php');?>
</body>
</html>
<script type="text/javascript">
	$('document').ready(function(){
	$('#tbl_currentstock').DataTable();

    var t1 = $('#todaysales').DataTable({
    	bFilter: false,
     	lengthChange: false,
     	bPaginate: false,
     	bInfo: false,
        buttons: [ 'copy', 'excel', 'pdf' ]
     });
      t1.buttons().container()
        .appendTo( '#todaysales_wrapper .col-md-6:eq(0)' );

	});
</script>