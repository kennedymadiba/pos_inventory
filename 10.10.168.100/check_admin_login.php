<?php 
session_start();

include('includes/db_connect.php');

$username=$password=$error_username=$error_password='';
$error = 0;

if(empty($_POST['username']))
{
   $error_username = "username is required";
   $error++;
}
else
{
  $username = $_POST['username'];
}
if(empty($_POST['password']))
{
   $error_password = "Password is required";
   $error++;
}
else
{
  $password = md5($_POST['password']);
}

if($error == 0)
{
	$query = "SELECT * FROM tbl_admin WHERE username=?";
	$stmt = $connect->prepare($query);
	$stmt->bind_param("s",$_POST['username']);

	if($stmt->execute())
	{
      $result = $stmt->get_result();
      if($result->num_rows > 0)
      {
         $row = $result->fetch_assoc();
         if($password == $row['password'])
          {
            $_SESSION['admin_id'] = $row['admin_id'];
          }
          else
          {
            $error_password = "Wrong password";
            $error++;
          }
      }
      else
      {
        $error_username = "Wrong Username";
        $error++;
      }
	}
}

if($error > 0)
{
	$output = array(
         'error'=>true,
         'error_username'=>$error_username,
         'error_password'=>$error_password
	);
}
else
{
	$output = array(
         'success'=>true
	);
}

echo json_encode($output);

?>