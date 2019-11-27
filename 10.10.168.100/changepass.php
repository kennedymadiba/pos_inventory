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
      Update your password
 	</div>
 	<div class="card-body">
     <div class="row">
     	 <div class="col-md-7 offset-md-1">
     	 	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
     	 	  <div class="form-group">
			      <div class="row">
			      <label class="col-md-4 text-right">Your old password <span style="color: red;">*</span></label>
			         <div class="col-md-8">
			            <input type="password" name="updatebp" id="updatebp" class="form-control">
			          </div>
			      </div>	
			   </div>
			   <div class="form-group">
			      <div class="row">
			      <label class="col-md-4 text-right">Enter new password <span style="color: red;">*</span></label>
			         <div class="col-md-8">
			            <input type="password" name="updatebp" id="updatebp" class="form-control">
			          </div>
			      </div>	
			   </div>
			   <div class="form-group">
			      <div class="row">
			      <label class="col-md-4 text-right">Retype new password <span style="color: red;">*</span></label>
			         <div class="col-md-8">
			            <input type="password" name="updatebp" id="updatebp" class="form-control">
			          </div>
			      </div>	
			   </div>
			   <div class="form-group">
			   	<div class="row">
			   		<div class="col-md-4 offset-md-4">
			   		<input type="submit" name="btn_update" id="btn_update" class="btn btn-success btn-sm" value="Update">	
			   		</div>
			   	</div>
			   </div>
     	 	</form>
     	 </div>
     </div>
 	</div>
 </div>

</div>

<?php include('plugins/js.php');?>
</body>
</html>