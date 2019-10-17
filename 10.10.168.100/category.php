<?php 
session_start();

if(!isset($_SESSION['admin_id']))
{
	header('location:login.php');
}else{
	include('catAction.php');
	include('includes/db_connect.php');

  if(isset($_POST['btn_edit']))
  {
    $key = $_POST['editkey'];
    $editname = $_POST['editcat'];
    
    $data=array('name'=>$editname);
    $db->where ('category_id', $key);
    if ($db->update ('category', $data)){
      $_SESSION['response']="Successfully edited";
      $_SESSION['res_type']="success";
    }else{
      $_SESSION['response']="Something went wrong! try again";
      $_SESSION['res_type']="danger";
    }
  }

  if(isset($_POST['btn_delete']))
  {
    $deletekey = $_POST['deletekey'];
    $db->where('category_id', $deletekey);
    if($db->delete('category')){
      $_SESSION['response']="Successfully deleted";
      $_SESSION['res_type']="danger";
    } 
  }
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
		         <a href="#delete<?=$id?>" data-toggle="modal"><button type="button" class="btn btn-danger btn-sm">Delete</button></a> |
		         <a href="#edit<?=$id?>" data-toggle="modal"><button type="button" class="btn btn-success btn-sm">Edit</button></a>
		        </td>
			  	</tr>
          
          <!-- edit modal -->
           <div class="modal" id="edit<?=$id?>">
            <div class="modal-dialog" role="document">
              <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="edit_form">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modal_title">Edit</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <div class="row">
                      <label class="col-md-4 text-right">Category Name</label>
                          <div class="col-md-8">
                            <input type="hidden" name="editkey" class="form-control" value="<?=$id?>">
                            <input type="text" name="editcat" id="editcat" class="form-control" value="<?=$row['name']?>">
                          </div>
                    </div>  
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="submit" name="btn_edit" id="btn_edit" class="btn btn-success btn-sm" value="Edit">
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
              </div>
               </form>
            </div>
          </div>
          <!-- // edit modal -->
          <!-- delete modal -->
          <div class="modal" id="delete<?=$id?>">
            <div class="modal-dialog" role="document">
              <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="delete_form">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modal_title">Delete</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                      <input type="hidden" name="deletekey" class="form-control" value="<?=$id?>">
                  </div>
                  <div class="alert alert-danger" role="alert">
                    Confirm deleting <b><?=$row['name']?></b> ?
                  </div>  
                </div>
                <div class="modal-footer">
                  <input type="submit" name="btn_delete" id="btn_delete" class="btn btn-success btn-sm" value="Delete">
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
              </div>
               </form>
            </div>
          </div>
          <!-- // delete modal -->
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
        <h5 class="modal-title" id="modal_title">Add Category</h5>
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