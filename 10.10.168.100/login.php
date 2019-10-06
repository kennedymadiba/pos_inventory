<?php
include('includes/db_connect.php');
session_start();

if(isset($_SESSION["admin_id"]))
{
 header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   
    <title>pos + inventory</title>
  </head>
  <body>
  <div class="jumbotron text-center" style="margin-bottom:0">
    <h1>Point of Sale + Invenntory System</h1>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-md-4 offset-md-4 mt-5">

      <div class="card">
        <div class="card-header">
          Admin Login
        </div>
        <div class="card-body">
          <form method="post" id="admin_login">

            <div class="form-group">
              <label>Enter Username</label>
              <input type="text" name="username" id="username" class="form-control">
              <span id="error_username" class="text-danger"></span>
            </div>

            <div class="form-group">
              <label>Enter Password</label>
              <input type="password" name="password" id="password" class="form-control">
              <span id="error_password" class="text-danger"></span>
            </div>

            <div class="form-group">
              <input type="submit" name="submit" id="btn_login" class="btn btn-info" value="Login">
            </div>
            
          </form>
        </div>
       </div>

      </div>
      
    </div>
  </div>
  
 
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

  <!-- JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  </body>
</html>
  <!-- custom js -->
  <script type="text/javascript">
    $(document).ready(function(){
     $('#admin_login').on('submit', function(event){
      event.preventDefault();
      $.ajax({
         method:"POST",
         url:"check_admin_login.php",
         data:$(this).serialize(),
         dataType:"json",
         beforeSend:function(){
          $('#btn_login').val('validating..');
          $('#btn_login').attr('disabled', 'disabled');
         },
         success:function(data){
           if(data.success)
           {
            location.href = "<?php echo $base_url;?>10.10.168.100/index.php";
           }
           if(data.error)
           {
            $('#btn_login').val('Login');
            $('#btn_login').attr('disabled', false);
            if(data.error_username != '')
            {
              $('#error_username').text(data.error_username);
            }
            else
            {
              $('#error_username').text('');
            }
            if(data.error_password != '')
            {
              $('#error_password').text(data.error_password);
            }
            else
            {
              $('#error_password').text('');
            }
           }
         }
      });
     });
    });
  </script>