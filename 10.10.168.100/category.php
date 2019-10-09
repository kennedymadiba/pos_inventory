<?php 
session_start();

if(!isset($_SESSION['admin_id']))
{
	header('location:login.php');
}else{
	include('catAction.php');
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
 				List of Categories
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
      <span class="alert" id="message_operation"></span>
 			<table class="table table-hover" id="tbl_category">
          <thead>
	          	<tr>
	          	 <th>Category Name</th>
			  	 <th>Actions</th>
	          	</tr>
	         </thead>
	         <tbody>
	         <?php
              $categories = $db->get('category');
             foreach ($categories as $row) 
             {
             	$id = $row['category_id'];
	         ?>
              <tr>
			  	 <td><?=$row['name']?></td>
			  	 <td>
		         <a href="details.php?details=<?=rand ( 10000 , 99999 ).$row['id']?>"><button type="button" class="btn btn-primary btn-sm">Details</button></a> |
		         <a href="action.php?deleterecord=<?=$row['id']?>" onclick="return confirm('Confirm deleting this record');"><button type="button" class="btn btn-danger btn-sm">Delete</button></a> |
		         <a href="index.php?edit=<?=rand ( 10000 , 99999 ).$row['id']?>"><button type="button" class="btn btn-success btn-sm">Edit</button></a>
		        </td>
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

<!-- add modal -->
<div class="modal" id="addModal">
  <div class="modal-dialog" role="document">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="student_form">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">Category Name
                <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="category" id="category" class="form-control" required>
                  <span class="text-danger"></span>
                </div>
          </div>  
        </div>
      <div class="modal-footer">
        <input type="hidden" name="student_id" id="student_id">
        <input type="hidden" name="action" id="action" value="Add">
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
 $('#tbl_category').DataTable();

 var state = false;
 $('#category').on('blur', function(){
  var category = $('#category').val();
  if (category == '') {
  	state = false;
  	return;
  }
  $.ajax({
    url: 'catAction.php',
    type: 'post',
    data: {
    	'cat_check' : 1,
    	'category' : category,
    },
    success: function(response){
      if (response == 'exist' ) {
      	state = false;
      	$('#category').siblings("span").text('Name of the category exist');
      }else if (response == 'not_exist') {
      	state = true;
      	$('#category').siblings("span").text('');
      }
    }
  });
 });

 });
</script>