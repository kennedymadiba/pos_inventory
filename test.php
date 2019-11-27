<?php
session_start();

  include_once '10.10.168.100/includes/db_connect.php';


  //get latest trans id
    $sql = "SELECT transaction_id FROM transaction ORDER BY id DESC LIMIT 1";
    $exe = $connect->query($sql);
    if(mysqli_num_rows($exe)>0)
    {
        while($row = $exe->fetch_assoc())
        {
            $trans_id = $row['transaction_id']+1;
        }
    }
    else{
        $trans_id = 1;
    }




  if(isset($_POST['transaction']))
  {
      $code = $_SESSION['barray'];
      $price = $_SESSION['parray'];
      $qty = $_SESSION['qarray'];
      $time = date("d-M-Y");


      $i=0;

      while($i<count($code)){

          $sql ="INSERT INTO transaction(code,qty,price,transaction_id,time) VALUES ('$code[$i]','$qty[$i]','$price[$i]','$trans_id','$time')";
          $exe = $connect->query($sql);
          $i++;
      }
  }
//start here

  

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.10/css/mdb.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <title>Hello, world!</title>
    <script src="engine.js"></script>
    <link rel="stylesheet" href="mobileTab.css">
    <link rel="stylesheet" href="custom.css">

    <style>
table {
	max-width:980px;
	table-layout:fixed;
	margin:auto;
}



thead, tfoot {
	display:table;
	width:100%;
	width:calc(100% - 18px);
}
tbody {
	height:250px;
	overflow:auto;
	overflow-x:hidden;
	display:block;
	width:100%;
}
tbody tr {
	display:table;
	width:100%;
	table-layout:fixed;
}
.items{
  height:390px;
	overflow:auto;
	overflow-Y:hidden;
  width:100%;

}
.slev{
  width: 40px;
  height: 40px;
  padding: 6px 0px;
  border-radius: 100%;
  text-align: center;
  font-size: 14px;
  line-height: 1.42857;" data-toggle="modal" data-target="#menu"><small class="fa fa-clipboard"></small>
}
.masta{
  width: 40px;
  height: 40px;
  padding: 6px 0px;
  border-radius: 100%;
  text-align: center;
  font-size: 14px;
  line-height: 1.42857;" data-toggle="modal" data-target="#menu"><small class="fa fa-clipboard"></small>
}
</style>

    <script>
  $(document).ready(function(){

    $(".masta").click(function(){
      //  $(".slave").toggle();
       setTimeout(function(){
         $(".slev1").toggle();
       }, 10);

       setTimeout(function(){
         $(".slev2").toggle();
       }, 50);

       setTimeout(function(){
         $(".slev3").toggle();
       }, 90);
       setTimeout(function(){
         $(".slev4").toggle();
       }, 130);
    });
    $(".stats").click(function(){
      $(".tytol").text("Stats");
    });
    $(".profile").click(function(){
      $(".tytol").text("Profile");
    });

  });


</script>



</head>




<body style="background-color:#011627;" >

<nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark " style="box-shadow:none; background-color:#011627;">

  <button class="btn btn-primary  masta"><small class="fa fa-list"></small></button>
  <button class="btn btn-warning slev slev2 stats" style="display:none;" data-toggle="modal" data-target="#menu"><small class="fa fa-chart-line"></small></button>
  <button class="btn btn-warning slev slev3 profile" style="display:none;" data-toggle="modal" data-target="#menu"><small class="fa fa-cogs"></small></button>
  <button class="btn btn-warning slev slev4 "style="display:none;" ><small class="fa fa-power-off"></small></button>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>


  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <a class="navbar-brand" href="#">Pos</a>

  </div>
</nav>



<!-- Modal -->
<div class="modal fade" id="menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title tytol" id="exampleModalLongTitle">Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</body>

<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.10/js/mdb.min.js"></script>
</body>
</html>
