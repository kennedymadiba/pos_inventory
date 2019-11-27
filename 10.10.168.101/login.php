<?php
include('includes/db_connect.php');
session_start();

if(isset($_SESSION["admin_id"]))
{
 header('location:index.php');
}

?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>POS + INVENTORY SYSTEM</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="brandimages/codei.png">
    <link rel="shortcut icon" href="brandimages/codei.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

  <style type="text/css">
      .login-logo h2{
       margin-top: 50px;
      }
  </style>
</head>
<body class="bg-dark">

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.php">
                        <!-- <img class="align-content" src="brandimages/C.png" alt=""> -->
                        <h2>POS + INVENTORY SYSTEM</h2>
                        <h3>Admin Login</h3>
                    </a>
                </div>
                <div class="login-form">
                    <form method="post" id="admin_login">
                        <div class="form-group">
                            <label>Enter Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                            <span id="error_username" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            <span id="error_password" class="text-danger"></span>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                            <label class="pull-right">
                                <a href="#">Forgotten Password?</a>
                            </label>

                        </div>
                        <input type="submit" name="submit" id="btn_login" class="btn btn-success btn-flat m-b-30 m-t-30" value="Login">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <!-- <script src="assets/js/main.js"></script> -->

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
            location.href = "<?php echo $base_url;?>10.10.168.101/index.php";
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