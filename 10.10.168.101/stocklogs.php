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
	          	 <th>Item quantity</th>
	          	 <th>Stock Added</th>
	          	 <th>Supplier</th>
	          	</tr>
	          </thead>
	          <tbody>
	           <?php
	            $query = "SELECT stock.code,stock.item_quantity,stock.date_arrival,stock.quantity,stock.supplier,product.name,product.unit FROM stock INNER JOIN product ON stock.code = product.code ORDER BY stock.id DESC";
	            $result = $connect->query($query);
	            while ($row = $result->fetch_assoc())
	            {
	            
	            ?>
	            <tr>
	             <td><?=$row['date_arrival']?></td>
	             <td><?=$row['code']?></td>
	             <td><?=$row['name']?></td>
	             <td><?=$row['item_quantity'].$row['unit']?></td>
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
      var t = $('#tbl_stocklogs').DataTable({
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
      });
      t.buttons().container()
        .appendTo( '#tbl_stocklogs_wrapper .col-md-6:eq(0)' );

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