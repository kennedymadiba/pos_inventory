<?php 
session_start();

if(!isset($_SESSION['admin_id']))
{
	header('location:login.php');
}else{
	include('productAction.php');
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
     <div class="row">
 			<div class="col-md-9">
 				Products
 			</div>
 			<div class="col-md-3">
 				<button type="button" id="btn_add" data-toggle="modal" data-target="#addModal" class="btn btn-info btn-sm" style="float: right;">Add</button>
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
          	 <th>Item quantity(ML)</th>
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
              <td><?=$row['item_quantity']?></td>
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
			        <h5 class="modal-title text-light" id="exampleModalLabel">Teacher Id: <?=$row['id']?></h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <div class="text-center">
						<img src="<?=$row['image']?>" width="250" class="img-thumbnail">
					</div>
					<h5 class="text-light">NAME: <?=$row['name']?></h5>
					<h5 class="text-light">EMAIL: <?=$row['email']?></h5>
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
			        <h5 class="modal-title" id="modal_title">Edit Teacher</h5>
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
			        		<label class="col-md-4 text-right">Name</label>
			                <div class="col-md-8">
			                	<input type="text" name="name" value="<?=$row['name']?>" id="name" class="form-control">
			                </div>
			        	</div>	
			        </div>
			        <div class="form-group">
			        	<div class="row">
			        		<label class="col-md-4 text-right">Email</label>
			                <div class="col-md-8">
			                	<input type="email" name="email" value="<?=$row['email']?>" id="email1" class="form-control">
			                </div>
			        	</div>	
			        </div>
			        <div class="form-group">
			        	<div class="row">
			        		<label class="col-md-4 text-right">Teacher Id</label>
			                <div class="col-md-8">
			                	<input type="text" value="<?=$row['teacher_id']?>" class="form-control" disabled>
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
                    <h5 class="modal-title" id="exampleModalLabel">Delete Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                      Confirm deleting <?=$row['name']?>'s account ?
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

</div>

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
        		<label class="col-md-4 text-right">Item Quantity(ML)
                <span class="text-danger">*</span></label>
                <div class="col-md-8">
                	<input type="number" name="item_quantity" id="item_quantity" class="form-control" required>
                	<span class="text-danger"></span>
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

<?php include('plugins/js.php');?>
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

 });
</script>