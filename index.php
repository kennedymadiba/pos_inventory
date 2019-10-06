<?php
  include_once '10.10.168.100/includes/db_connect.php';

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

    <title>Hello, world!</title>
    <script>
        $(document).ready(function(){

            $("button").click(function(){
                var product=$(this).val();
                $.post("pos.php",{product:product},function(data){
                    // if(jQuery.inArray(product, cart)==0){
                        $("tbody").append(data);
                });
            });
        });

    </script>
</head>
<body style="background: #F1F3F4;">

<div class="container-fluid" STYLE="margin-top:10px;">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <table class="table" id="cart-item-table-header">
                        <thead>
                        <tr class="active">
                            <td width="100" class="text-right"> Barcode</td>
                            <td width="200" class="text-left">Items</td>
                            <td width="120" class="text-center hidden-xs">Unit Price</td>
                            <td width="100" class="text-center">Quantity</td>
                            <td width="100" class="text-right">Total Price</td>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Products count ( 0 )</th>
                            <th></th>
                            <th></th>
                            <th>Sub Total</th>
                            <th>0 ksh</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Discount</th>
                            <th>0 ksh</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Shipping</th>
                            <th>0 ksh</th>
                        </tr>
                        <tr style="background:#DFF0D8;">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Net payable</th>
                            <th>0 ksh</th>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="form-row align-items-center">
                            <div class="col-auto" style="width:100%;">
                                <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                <div class="input-group mb-2" >
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><span class="fa fa-search"></span></div>
                                        <div class="input-group-text"><span class="fa fa-barcode"></span></div>
                                    </div>
                                    <input type="text" class="form-control col-12" id="inlineFormInputGroup" placeholder="Barcode, product name, code" >
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="container">
                        <div class="row">

                            <div>
                                <button class="btn btn-primary btn-sm">All</button>
                                <?php
                                $sql = "SELECT name,category_id FROM category";
                                $exe = $connect->query($sql);
                                while($row = $exe->fetch_assoc()) {

                                    $id = $row['category_id'];
                                    ?>
                                    <button class="btn btn-default btn-sm" value="<?=$id?>"><?=$row['name']?></button>

                                    <?php

                                }

                                ?>
                            </div>
                            <?php
                                $sql = "SELECT * FROM product WHERE quantity>0";
                                $exe = $connect->query($sql);
                                while($row = $exe->fetch_assoc())
                                {
                                    $product = array($row['code'],$row['name'],$row['sp']);
                                    $image = $row['image'];

                                    ?>


                                    <button value="<?php echo $product[0].','.$product[1].','.$product[2]?>" class="col-md-2 tsk" style="background-color:white;border:1px solid gray;margin-top:8px;margin-right:8px;" id="product">
                                        <img src="<?="10.10.168.100/$image"?>" alt="<?=$row['name']?>"  width="50px;">
                                        <small class="text-info"><?=$row['name']?></small><br>(<small><?=$row['item_quantity']?> ml</small>)
                                        <br>

                                        <small><?=$row['code']?></small>
                                    </button>
                                <?php
                                }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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