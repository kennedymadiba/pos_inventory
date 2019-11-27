<?php
session_start();
date_default_timezone_set('Africa/Nairobi');

if(!isset($_SESSION['admin_id']))
{
	header('location:login.php');
}else{
	include('includes/db_connect.php');
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
 	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>POS + INVENTORY SYSTEM</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include('plugins/style.php');?>
</head>
<body>
<?php include('plugins/nav.php');?>
<!-- Content -->
<div class="content">
     <!-- Animated -->
    <div class="animated fadeIn">

     <div class="card">
     	<div class="card-body">
     		<h4 class="mb-3">Daily Sales </h4>
	 	 	<div class="table-responsive">
	       	<table class="table table-hover" id="dailyreport">
	          <thead>
	          	<tr>
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

    </div>
     <!--/.animated -->
</div>
 <!-- /.content -->
        <div class="clearfix"></div>
        <!-- Footer -->
        <footer class="site-footer" style="bottom: 0;">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-6">
                        Copyright &copy; 2019 <a href="https://codeisystems.co.ke/" target="_blank">Codei</a>
                    </div>
                    <!-- <div class="col-sm-6 text-right">
                        Designed by <a href="">Colorlib</a>
                    </div> -->
                </div>
            </div>
        </footer>
        <!-- /.site-footer -->
 </div>
 <!-- /#right-panel -->

<?php include('plugins/js.php');?>
<?php include('plugins/dataT.php');?>
</body>
</html>
<script type="text/javascript">
	$('document').ready(function(){

    var t1 = $('#dailyreport').DataTable({
    	bFilter: false,
     	lengthChange: false,
     	bPaginate: false,
     	bInfo: false,
        buttons: [ 'copy', 'excel', 'pdf' ]
     });
      t1.buttons().container()
        .appendTo( '#dailyreport_wrapper .col-md-6:eq(0)' );

	$('#menuToggle').on('click', function(event) {
	    var windowWidth = $(window).width();       
	    if (windowWidth<1010) { 
	      $('body').removeClass('open'); 
	      if (windowWidth<760){ 
	        $('#left-panel').slideToggle(); 
	      } else {
	        $('#left-panel').toggleClass('open-menu');  
	      } 
	    } else {
	      $('body').toggleClass('open');
	      $('#left-panel').removeClass('open-menu');  
	    } 
	       
	  }); 

	   
	  $(".menu-item-has-children.dropdown").each(function() {
	    $(this).on('click', function() {
	      var $temp_text = $(this).children('.dropdown-toggle').html();
	      $(this).children('.sub-menu').prepend('<li class="subtitle">' + $temp_text + '</li>'); 
	    });
	  });

	  $(window).on("load resize", function(event) { 
	    var windowWidth = $(window).width();       
	    if (windowWidth<1010) {
	      $('body').addClass('small-device'); 
	    } else {
	      $('body').removeClass('small-device');  
	    } 
	    
	  });

	});
</script>