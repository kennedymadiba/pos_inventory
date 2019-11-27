<?php
session_start();

if(!isset($_SESSION['admin_id']))
{
	header('location:login.php');
}else{

  include('includes/db_connect.php');
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
<div class="container mt-5">
 
 <div class="card">
 	<div class="card-header">
      List of Added Stocks
 	</div>
   <div class="card-body">
     <div class="table-responsive">
       <table class="table table-hover" id="tbl_stocklogs">
          <thead>
          	<tr>
          	 <th>Date</th>
          	 <th>Item Code</th>
          	 <th>Name</th>
          	 <th>Item quantity(ML)</th>
          	 <th>Stock Added</th>
          	 <th>Supplier</th>
          	</tr>
          </thead>
          <tbody>
           <?php
            $query = "SELECT stock.code,stock.item_quantity,stock.date_arrival,stock.quantity,stock.supplier,product.name FROM stock INNER JOIN product ON stock.code = product.code ORDER BY stock.id DESC";
            $result = $connect->query($query);
            while ($row = $result->fetch_assoc())
            {
            
            ?>
            <tr>
             <td><?=$row['date_arrival']?></td>
             <td><?=$row['code']?></td>
             <td><?=$row['name']?></td>
             <td><?=$row['item_quantity']?></td>
             <td><?=$row['quantity']?></td>
             <td><?php
              if($row['supplier']==''){
              	echo "N/A";
              }else{
              	echo $row['supplier'];
              }
             ?></td>
            </tr>
            <?php
            }
           ?>
          </tbody>
      </table>
     </div>
   </div>
</div>
</div>

<?php include('plugins/js.php');?>
<?php include('plugins/datatablejs.php');?>
</body>
</html>
<script type="text/javascript">
	$('document').ready(function(){
      var t = $('#tbl_stocklogs').DataTable({
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
      });
      t.buttons().container()
        .appendTo( '#tbl_stocklogs_wrapper .col-md-6:eq(0)' );
	});
</script>