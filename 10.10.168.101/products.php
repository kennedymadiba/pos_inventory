<?php 
session_start();

if(!isset($_SESSION['admin_id']))
{
	header('location:login.php');
}else{
	include('productAction.php');
	include('includes/db_connect.php');
  	date_default_timezone_set('Africa/Nairobi');

  if(isset($_POST['add_stock']))
  {
    $product = $_POST['product'];
    $exploded_product = explode('|', $product);
    $product_c = $exploded_product[0];
    $product_q = $exploded_product[1];
    $quantity = $_POST['quantity'];
    $ex_date = $_POST['ex_date'];
    $supplier = $_POST['supplier'];

    $date_arrival = date("Y-m-d H:i:s");
    $data = array("code"=>$product_c,"item_quantity"=>$product_q,"date_arrival"=>$date_arrival,"ex_date"=>$ex_date,"quantity"=>$quantity,"supplier"=>$supplier);
    if($db->insert('stock',$data))
    {
      $up = $connect->query("UPDATE product SET quantity=quantity+'$quantity' WHERE code='$product_c'");
      $_SESSION['response']=$quantity." of stock added successfully";
      $_SESSION['res_type']="success";
    }
  }
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
   <div class="content-fluid">
     <!-- Animated -->
     <div class="animated fadeIn">

		 <div class="card">
		 	<div class="card-header">
		     <div class="row">
		 			<div class="col-md-9">
		 				Products
		 			</div>
		 			<div class="col-md-3">
		 				<button type="button" id="btn_add" data-toggle="modal" data-target="#addModal" class="btn btn-info btn-sm ml-1" style="float: right;">Add Product</button>
		        <button type="button" id="btn_update" data-toggle="modal" data-target="#updateModal" class="btn btn-info btn-sm" style="float: right;">Update Stock</button>
		 			</div>
		 	 </div>
		 	</div>
		   <div class="card-body">
		   	   <?php if(isset($_SESSION['response'])){ ?>
			     <div class="alert alert-<?=$_SESSION['res_type']?> alert-dismissible">
			      <button type="button" class="close" data-dismiss="alert">&times;</button>
			      <?=$_SESSION['response']?>
			    </div>
		     <?php } unset($_SESSION['response']); ?>
		   	<div class="table-responsive">
		       <table class="table table-hover" id="tbl_products">
		          <thead>
		          	<tr>
		          	 <th>Image</th>
		          	 <th>Item Code</th>
		          	 <th>Name</th>
		          	 <th>Item quantity</th>
		          	 <th>Category</th>
		          	 <th>B.P(ksh)</th>
		          	 <th>S.P(ksh)</th>
		          	 <th>Profit(ksh)</th>
		          	 <th>Quantity</th>
		          	 <th>View</th>
		          	 <th>Edit</th>
		          	 <th>Delete</th>
		          	</tr>
		          </thead>
		          <tbody>
		          	<?php
		             $products = $db->get('product');
		             foreach ($products as $row) 
		             {
		             	$id = $row['id'];
		              $cat_id=$row['category_id'];
		              // fetch category
		              $sql = "SELECT name FROM category WHERE category_id='$cat_id'";
		              $res = $connect->query($sql);
		              $ans = $res->fetch_assoc();
		              $category = $ans['name'];
		             ?>
		             <tr>
		             	<td><img src="<?=$row['image']?>" width="50"></td>
		             	<td><?=$row['code']?></td>
		             	<td><?=$row['name']?></td>
		              <td><?=$row['item_quantity'].$row['unit']?></td>
		             	<td><?=$category?></td>
		             	<td><?=$row['bp']?></td>
		             	<td><?=$row['sp']?></td>
		             	<td><?=$row['sp']-$row['bp']?></td>
		             	<td><?=$row['quantity']?></td>
		             	<td><button type="button" data-toggle="modal" data-target="#view<?=$id?>" class="btn btn-info btn-sm">View</button></td>
		             	<td><button type="button" data-toggle="modal" data-target="#edit<?=$id?>" class="btn btn-primary btn-sm">Edit</button></td>
		             	<td><button type="button" data-toggle="modal" data-target="#delete<?=$id?>" class="btn btn-danger btn-sm">Delete</button></td>
		             </tr>
		             <!-- View Modal -->
					<div class="modal" id="view<?=$id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content bg-info rounded">
					      <div class="modal-header">
					        <h5 class="modal-title text-light" id="exampleModalLabel">Product: <?=$row['name']."(".$row['item_quantity'].$row['unit'].")"?></h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <div class="text-center">
								<img src="<?=$row['image']?>" width="250" class="img-thumbnail">
							</div>
							<h5 class="text-light">Code: <?=$row['code']?></h5>
							<h5 class="text-light">Current Quantity: <?=$row['quantity']?></h5>
					      </div>
					    </div>
					  </div>
					</div>
		            
		            <!-- edit modal -->
					<div class="modal" id="edit<?=$id?>"  tabindex="-1" role="dialog">
					  <div class="modal-dialog" role="document">
					  	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="modal_title">Edit Product</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					      	<div class="form-group">
					      		<input type="hidden" name="key" value="<?=$id?>">
					      	</div>
					        <div class="form-group">
					        	<div class="row">
					        		<label class="col-md-4 text-right">B.P</label>
					                <div class="col-md-8">
					                	<input type="number" name="updatebp" value="<?=$row['bp']?>" id="updatebp" class="form-control">
					                </div>
					        	</div>	
					        </div>
					        <div class="form-group">
					        	<div class="row">
					        		<label class="col-md-4 text-right">S.P</label>
					                <div class="col-md-8">
					                	<input type="number" name="updatesp" value="<?=$row['sp']?>" id="updatesp" class="form-control">
					                </div>
					        	</div>	
					        </div>
					        <div class="form-group">
					        	<div class="row">
					        		<label class="col-md-4 text-right">Select Image</label>
					                <div class="col-md-8">
					                	<input type="hidden" name="oldimage" value="<?=$row['image']?>">
					                	<input type="file" name="image" class="form-control-file">
					                	<img src="<?=$row['image']?>" width="120" class="img-thumbnail">
					                </div>
					        	</div>	
					        </div>
					      </div>
					      <div class="modal-footer">
					      	<input type="submit" name="btn_update" id="btn_update" class="btn btn-success btn-sm" value="Update">
					        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					     </form>
					  </div>
					</div>	

					<!-- delete modal -->
					<div class="modal" id="delete<?=$id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		              <div class="modal-dialog" role="document">
		                <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" id="add_class_form">
		                <div class="modal-content">
		                  <div class="modal-header">
		                    <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
		                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                      <span aria-hidden="true">&times;</span>
		                    </button>
		                  </div>
		                  <div class="modal-body">
		                    <div class="alert alert-danger" role="alert">
		                      Confirm deleting <?=$row['name']?> from inventory ?
		                    </div>
		                  </div>
		                  <div class="modal-footer">
		                    <input type="hidden" name="key" value="<?=$id?>">
		                    <input type="submit" name="btn_delete" id="btn_delete" class="btn btn-success btn-sm" value="Delete">
		                    <button type="submit" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
		                  </div>
		                </div>
		              </form>
		              </div>
		            </div>
		             <?php
		             }
		          	?>
		          </tbody>
		       </table>
			</div>
		   </div>
		 </div>

		<!-- add product -->
		<div class="modal" id="addModal"  tabindex="-1" role="dialog">
		  <div class="modal-dialog" role="document">
		  	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="modal_title">Add New Product</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <div class="form-group">
		        	<div class="row">
		        		<label class="col-md-4 text-right">Item Code
		                <span class="text-danger">*</span></label>
		                <div class="col-md-8">
		                	<input type="text" name="code" id="code" class="form-control" required>
		                	<span class="text-danger"></span>
		                </div>
		        	</div>	
		        </div>
		        <div class="form-group">
		        	<div class="row">
		        		<label class="col-md-4 text-right">Name
		                <span class="text-danger">*</span></label>
		                <div class="col-md-8">
		                	<input type="text" name="name" id="name" class="form-control" required>
		                	<!-- <span class="text-danger" id="error_class_name"><?=$error_email?></span> -->
		                	<span class="text-danger"></span>
		                </div>
		        	</div>	
		        </div>
		        <div class="form-group">
		        	<div class="row">
		        		<label class="col-md-4 text-right">Item Quantity
		                <span class="text-danger">*</span></label>
		                <div class="col-md-8">
		                	<input type="number" name="item_quantity" id="item_quantity" class="form-control" required>
		                	<span class="text-danger"></span>
		                </div>
		        	</div>	
		        </div>
		        <div class="form-group">
		        	<div class="row">
		        		<label class="col-md-4 text-right">Metric unit
		                <span class="text-danger">*</span></label>
		                <div class="col-md-8">
		                	<select class="form-control" id="exampleFormControlSelect1" name="unit" required>
		                	  <option selected disabled="disabled">select</option>
						      <option value="ml">ml</option>
						      <option value="g">g</option>
						      <option value="kg">kg</option>
						    </select>
		                </div>
		        	</div>	
		        </div>
		        <div class="form-group">
		        	<div class="row">
		        		<label class="col-md-4 text-right">Select Category
		                <span class="text-danger">*</span></label>
		                <div class="col-md-8">
		                	<select class="form-control" id="exampleFormControlSelect1" name="category" required>
		                	  <option selected disabled="disabled">select</option>
						      <?php
		                       $cats = $db->get('category');
		                       foreach ($cats as $row)
		                        {
		                       	?>
		                       	<option value="<?=$row['category_id']?>"><?=$row['name']?></option>
		                       	<?php
		                       }
						      ?>
						    </select>
		                </div>
		        	</div>	
		        </div>
		        <div class="form-group">
		        	<div class="row">
		        		<label class="col-md-4 text-right">B.P
		                <span class="text-danger">*</span></label>
		                <div class="col-md-8">
		                	<input type="number" name="bp" id="bp" class="form-control" required>
		                	<span class="text-danger"></span>
		                </div>
		        	</div>	
		        </div>
		        <div class="form-group">
		        	<div class="row">
		        		<label class="col-md-4 text-right">S.P
		                <span class="text-danger">*</span></label>
		                <div class="col-md-8">
		                	<input type="number" name="sp" id="sp" class="form-control" required>
		                	<span class="text-danger"></span>
		                </div>
		        	</div>	
		        </div>
		        <div class="form-group">
		        	<div class="row">
		        		<label class="col-md-4 text-right">Quantity
		                <span class="text-danger">*</span></label>
		                <div class="col-md-8">
		                	<input type="number" name="quantity" id="quantity" class="form-control" required>
		                	<span class="text-danger"></span>
		                </div>
		        	</div>	
		        </div>
		        <div class="form-group">
		        	<div class="row">
		        		<label class="col-md-4 text-right">Select Image
		                <span class="text-danger">*</span></label>
		                <div class="col-md-8">
		                	<input type="file" name="image" class="form-control-file" id="photo" required>
		                </div>
		        	</div>	
		        </div>
		      </div>
		      <div class="modal-footer">
		      	<input type="submit" name="btn_action" id="btn_action" class="btn btn-success btn-sm" value="Add">
		        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		     </form>
		  </div>
		</div>

		<!-- update stock	 -->
		<div class="modal" id="updateModal"  tabindex="-1" role="dialog">
		  <div class="modal-dialog" role="document">
		    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="modal_title">Add stock</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <div class="form-group">
		          <div class="row">
		            <label class="col-md-4 text-right">Select Category
		                <span class="text-danger">*</span></label>
		                <div class="col-md-8">
		                  <select class="form-control" id="selectc" name="category" required onChange='change_category()'>
		                    <option selected disabled="disabled">select</option>
		                    <?php
		                       $cats = $db->get('category');
		                       foreach ($cats as $row)
		                        {
		                        ?>
		                        <option value="<?=$row['category_id']?>"><?=$row['name']?></option>
		                        <?php
		                       }
		                    ?>
		                  </select>
		                </div>
		          </div>  
		        </div>
		        <div class="form-group">
		          <div class="row">
		            <label class="col-md-4 text-right">Select Product
		                <span class="text-danger">*</span></label>
		                <div class="col-md-8" id="product">
		                  <select name="product" id="select2" class="form-control">
		                   <option value="">select product</option>
		                  </select>
		                </div>
		          </div>  
		        </div>
		        <div class="form-group">
		          <div class="row">
		            <label class="col-md-4 text-right">Quantity
		                <span class="text-danger">*</span></label>
		                <div class="col-md-8">
		                  <input type="number" name="quantity" id="quantity" class="form-control" required>
		                  <span class="text-danger"></span>
		                </div>
		          </div>  
		        </div>
		        <div class="form-group">
		          <div class="row">
		            <label class="col-md-4 text-right">Expiry Date(Optional)
		            </label>
		                <div class="col-md-8">
		                  <input type="date" name="ex_date" id="ex_date" class="form-control">
		                  <span class="text-danger"></span>
		                </div>
		          </div>  
		        </div>
		        <div class="form-group">
		          <div class="row">
		            <label class="col-md-4 text-right">Supplier(Optional)
		            </label>
		            <div class="col-md-8">
		              <input type="text" name="supplier" id="supplier" class="form-control">
		              <span class="text-danger"></span>
		            </div>
		          </div>  
		        </div>
		      </div>
		      <div class="modal-footer">
		        <input type="submit" name="add_stock" id="add_stock" class="btn btn-success btn-sm" value="Add">
		        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		     </form>
		  </div>
		</div>     	

     </div>
     <!-- .animated -->
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

  <!-- custom scripts -->
  <script type="text/javascript">
          function change_category(){
              var xmlhttp=new XMLHttpRequest();
              xmlhttp.open("GET","ajaxx.php?category="+document.getElementById("selectc").value , false);
        xmlhttp.send(null);
    
              document.getElementById("product").innerHTML=xmlhttp.responseText;
          }
  </script>

<?php include('plugins/js.php');?>
<?php include('plugins/dataT.php');?>
</body>
</html>
<script type="text/javascript">
 $('document').ready(function(){
 $('#tbl_products').DataTable();

 var state = false;
 $('#code').on('blur', function(){
  var code = $('#code').val();
  if (code == '') {
  	state = false;
  	return;
  }
  $.ajax({
    url: 'productAction.php',
    type: 'post',
    data: {
    	'code_check' : 1,
    	'code' : code,
    },
    success: function(response){
      if (response == 'exist' ) {
      	state = false;
      	$('#code').siblings("span").text('Item Code exist, should be unique!');
      }else if (response == 'not_exist') {
      	state = true;
      	$('#code').siblings("span").text('');
      }
    }
  });
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