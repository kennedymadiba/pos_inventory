<?php
include('includes/config.php');

if(isset($_POST['btn_action']))
{
  $cat = $_POST['category'];
      // validation
  $db->where ('name', $cat);
  if($db->get ('category'))
  {

      $_SESSION['response']="Action cannot be completed! try again";
      $_SESSION['res_type']="danger";
  }else
  {
  	$data = array("name"=>$cat);
    if($db->insert('category',$data))
    {
        $_SESSION['response']="New category added successfully";
        $_SESSION['res_type']="success";
    }
    else
    {

          $_SESSION['response']="Error while inserting";
          $_SESSION['res_type']="danger";
    }
  }
}

if (isset($_POST['cat_check'])) {
  	$category = $_POST['category'];
  	$db->where ('name', $category);
  	$results = $db->get ('category');
  	if ($results) {
  	  echo "exist";	
  	}else{
  	  echo 'not_exist';
  	}
  	exit();
  }
?>