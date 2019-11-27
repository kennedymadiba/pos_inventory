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
<html class="no-js" lang="en">
<head>
 	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>POS + INVENTORY SYSTEM</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include('plugins/style.php');?>

        <style>  
           .ulkk{  
                background-color:#eee;  
                cursor:pointer;  
           }  
           .kk{  
                padding:8px;
                margin-left: 65px;  
           }  
      </style>

</head>
<body>
<?php include('plugins/nav.php');?>
<!-- Content -->
  <div class="content">
     <!-- Animated -->
    <div class="animated fadeIn">

       <div class="row">
          <div class="col-lg-12">
          <form id="kkForm"  method="post">
            <div class="input-group input-group-lg">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-lg"><i class="fa fa-search"></i></span>
              <span class="input-group-text" id="inputGroup-sizing-lg"><i class="fa fa-barcode"></i></span>
             </div>
             <input type="text" class="form-control" aria-label="Large" name="searchcode" id="searchcode" aria-describedby="inputGroup-sizing-sm" required placeholder="Barcode">
              <input type="hidden" name="searching" value="kk">
              </div>
              </form>
              <div id="codeList"></div>
           </div>
        </div>

        <?php
          $searching='';
          if(isset($_POST['searching'])){
              $searching = $_POST['searching'];
           }
          
          if($_SERVER['REQUEST_METHOD'] == 'POST' && $searching=='kk')
          {
                     $searchcode = $_POST['searchcode'];
                     $db->where ("code", $searchcode);
                     $get_code=$db->get('product');
                     if($get_code){
                        foreach ($get_code as $row) {
                            $p_code = $row['code'];
                         }
                         $_SESSION['search_code']='';
                         $_SESSION['search_code']=$p_code;
                   }
            }

          if(isset($_SESSION['search_code']))
          {
            $code = $_SESSION['search_code'];
            $query = "SELECT * FROM product WHERE code = '$code'";
            $stmt = $connect->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc())
             {
               $p_name = $row['name'];
               $unit = $row['item_quantity'].$row['unit'];
               $qty = $row['quantity'];
               $bp = $row['bp'];
               $sp = $row['sp'];
             }

             $today = date("Y-m-d");
             $week = date('Y-m-d', strtotime('-7 days'));
             $sql = "SELECT * FROM transaction WHERE code='$code' AND time BETWEEN '$week' AND '$today'";
             
             $queryAll = "SELECT SUM(qty) as allqty FROM transaction WHERE time BETWEEN '$week' AND '$today'";
             $datatitle = "Weekly data (".$week.' - '.$today.")";
               if(isset($_POST['filter']))
               {
                  $from = $_POST['from'];
                  $to = $_POST['to'];

                  $fromday = date("Y-m-d",strtotime($from));
                  $to_day = date("Y-m-d",strtotime($to));

                  $sql = "SELECT * FROM transaction WHERE code='$code' AND time BETWEEN '$fromday' AND '$to_day'";
                  $queryAll = "SELECT SUM(qty) as allqty FROM transaction WHERE time BETWEEN '$fromday' AND '$to_day'";

                  $datatitle = "Data (".$fromday." - ".$to_day.")"; 
               }
             ?>
             <div class="row">
              <div class="col-md-10 offset-md-1 mt-3">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-5">
                        <h4><?=$datatitle?></h4>
                      </div>
                      <div class="col-md-7">
                        <form class="form-inline" method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
                      <label class="my-1 mr-2" for="">From</label>
                      <div class="input-group mb-1 mr-sm-2">
                          <input type="date" name="from" class="form-control" required>
                       </div>
                       <label class="my-1 mr-2" for="">To</label>
                      <div class="input-group mb-1 mr-sm-2">
                          <input type="date" name="to" class="form-control"  required>
                       </div>
                       <button type="submit" name="filter" class="btn btn-sm btn-secondary mb-1">Filter</button>
                      </form>
                      </div>
                    </div>
                    <div class="row mt-3">

                      <div class="col-md-6">
                        <ul class="list-group">
                          <li class="list-group-item border-0"><b>Barcode: </b><?=$code?></li>
                          <li class="list-group-item border-0"><b>Product name: </b><?=$p_name?></li>
                          <li class="list-group-item border-0"><b>Item quantity: </b><?=$unit?></li>
                          <li class="list-group-item border-0"><b>Current stock: </b><?=$qty?></li>
                        </ul>
                      </div>

                       <div class="col-md-5 offset-md-1">
                         <?php
                         $res = $connect->query($sql);
                         $totalqty = 0;
                         while ($ans = $res->fetch_assoc()){
                           $totalqty += $ans['qty'];
                         }
                         $profit = $sp-$bp;

                         $output = $connect->query($queryAll);
                         $r = mysqli_fetch_assoc($output);
                         $allqty = $r['allqty'];
                         $share = ($totalqty/$allqty)*100;
                         ?>
                         <ul class="list-group">
                          <li class="list-group-item border-0">Units sold: &nbsp; &nbsp; <?=$totalqty?></li>
                          <li class="list-group-item border-0">Profit made: &nbsp; &nbsp; ksh <?php echo number_format($profit*$totalqty); ?></li>
                          <li class="list-group-item border-0">Total units sold: &nbsp; &nbsp; <?=$allqty?></li>
                          <li class="list-group-item border-0">Product martket share: &nbsp; &nbsp; <?php echo number_format($share,2).'%';?></li>
                         </ul>
                       </div>

                    </div>
                  </div>
                </div>
              </div>
             </div>
             <?php
          }

        ?>

    </div>
     <!--/.animated -->
 </div>
 <!-- /.content -->
        <div class="clearfix"></div>
 </div>
 <!-- /#right-panel -->

<?php include('plugins/js.php');?>
<?php include('plugins/dataT.php');?>
</body>
</html>
<script type="text/javascript">
	$('document').ready(function(){
     
     $('#searchcode').keyup(function(){
           var query = $(this).val();  
           if(query != '')  
           {  
                $.ajax({  
                     url:"search.php",  
                     method:"POST",  
                     data:{query:query},  
                     success:function(data)  
                     {  
                          $('#codeList').fadeIn();  
                          $('#codeList').html(data);  
                     }  
                });  
           }  
      });  
      $(document).on('click', '.kk', function(){  
           $('#searchcode').val($(this).text());  
           $('#codeList').fadeOut();
           $('#kkForm').submit();  
      });


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