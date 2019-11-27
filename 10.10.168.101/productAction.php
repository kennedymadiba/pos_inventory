<?php
include('includes/config.php');

if(isset($_POST['btn_action']))
{
	$code = $_POST['code'];
	$name = $_POST['name'];
	$item_quantity = $_POST['item_quantity'];
  $unit = $_POST['unit'];
	$category = $_POST['category'];
	$bp = $_POST['bp'];
	$sp = $_POST['sp'];
	$quantity = $_POST['quantity'];

	$photo = $_FILES['image']['name'];
    $upload = "images/".$photo;

    $db->where ('code', $code);
  	$db->where ('category_id', $category);
  	if($db->get ('product'))
  	{

      $_SESSION['response']="Same Product exist in the same category!";
      $_SESSION['res_type']="danger";
  	}
  	else
  	{
      $data = array("code"=>$code,"name"=>$name,"image"=>$upload,"category_id"=>$category,"sp"=>$sp,"bp"=>$bp,"item_quantity"=>$item_quantity,"unit"=>$unit,"quantity"=>$quantity);
	    if($db->insert('product',$data))
	    {
	        $data = array("name"=>$name,"quantity"=>$quantity);
	        move_uploaded_file($_FILES['image']['tmp_name'], $upload);
	        $_SESSION['response']="New product added successfully";
	        $_SESSION['res_type']="success";
	    }
	    else
	    {

	          $_SESSION['response']="Error while inserting";
	          $_SESSION['res_type']="danger";
	    }
  	}
}

if (isset($_POST['code_check'])) {
  	$code = $_POST['code'];
  	$db->where ('code', $code);
  	$results = $db->get ('product');
  	if ($results) {
  	  echo "exist";	
  	}else{
  	  echo 'not_exist';
  	}
  	exit();
  }

  if(isset($_POST['btn_update']))
  {
    $updatekey = $_POST['key'];
    $updatebp = $_POST['updatebp'];
    $updatesp = $_POST['updatesp'];
    $oldimage = $_POST['oldimage'];
    
    if(isset($_FILES['image']['name']) && $_FILES['image']['name']!=""){
      $newimage = $_FILES['image']['name'];
      $upload = "images/".$newimage;
      unlink($oldimage);
      move_uploaded_file($_FILES['image']['tmp_name'], $upload);
    }else{
      $upload=$oldimage;
    }

    $data = array("image"=>$upload,"bp"=>$updatebp,"sp"=>$updatesp);
    $db->where ('id', $updatekey);
    if ($db->update ('product', $data)){
      $_SESSION['response']="Successfully edited";
      $_SESSION['res_type']="success";
    }else{
      $_SESSION['response']="Something went wrong! try again";
      $_SESSION['res_type']="danger";
    }
  }

  if(isset($_POST['btn_delete']))
  {
    $deletekey = $_POST['key'];
    $db->where ("id", $deletekey);
    $product = $db->getOne ("product");
    $imgpath = $product['image'];

    unlink($imgpath);

    $db->where ("id", $deletekey);
    if($db->delete('product')){
      $_SESSION['response']="Successfully deleted";
      $_SESSION['res_type']="danger";
    }
  }
?>