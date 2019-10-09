<?php
include('includes/config.php');

if(isset($_POST['btn_action']))
{
	$name = $_POST['name'];
	$username = $_POST['username'];

	$photo = $_FILES['image']['name'];
    $upload = "userImages/".$photo;

    $db->where ('username', $username);
  	if($db->get ('users'))
  	{

      $_SESSION['response']="Something went wrong, try again!";
      $_SESSION['res_type']="danger";
  	}
  	else
  	{
  		$data = array("name"=>$name,"username"=>$username,"image"=>$upload,"password"=>md5($username));
	    if($db->insert('users',$data))
	    {
	        move_uploaded_file($_FILES['image']['tmp_name'], $upload);
	        $_SESSION['response']="New user added successfully";
	        $_SESSION['res_type']="success";
	    }
	    else
	    {

	          $_SESSION['response']="Error while inserting";
	          $_SESSION['res_type']="danger";
	    }
  	}
}

if (isset($_POST['username_check'])) {
  	$username = $_POST['username'];
  	$db->where ('username', $username);
  	$results = $db->get ('users');
  	if ($results) {
  	  echo "exist";	
  	}else{
  	  echo 'not_exist';
  	}
  	exit();
  }
?>