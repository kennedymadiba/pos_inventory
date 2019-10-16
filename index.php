<?php
session_start();

  include_once '10.10.168.100/includes/db_connect.php';
  include_once 'fpdf/fpdf.php';


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

    <title>Hello, world!</title>
    <script>
    // $(document).on('click', ".product", function () {
        //    $.get("shop.php",function(data){
        //            $(".items").html(data);
        //        });
        //     });


        $(document).ready(function(){



            setInterval(function(){
                $.get("shop.php",function(data){
                   $(".items").html(data);
               });
            
            }, 1000);
                      
            var barcode=[];
            var quantity=[];
            var name=[];
            var price=[];
            var countlicks=0;
            $(document).on('click', ".product", function () {
                
                countlicks=countlicks+1;
                var product=$(this).val();
                var split=product.split(",");

                if(countlicks<=split[2]){
                
                //check amount of product selected remaining;
                $.post("checkIfExistInDb.php",{code:split[0]},function(data){
                    
                if(data>0){
                    //reduce inventory on click
                $.post("dbToCart.php",{reduceInventory:split[0]},function(data){
                    //refresh page
                      $.get("shop.php",function(data){
                           $(".items").html(data);
                      }); 
                     //refresh page end 
                 });   
                }
                });
                
                if (barcode.length == 0) {
                    barcode.push(split[0]);
                    name.push(split[1]);
                    price.push(split[2]);
                    quantity.push(1);
                                      
                    
                 }else{
                     if(barcode.includes(split[0])){
                        var count=barcode.length;
                        
                        var i=0;
                        while(i<count){
                            if(barcode[i]===split[0]){
                            quantity[i]=parseInt(quantity[i], 10)+1;
                            }
                            i++;
                        }
                     }else{
                        barcode.push(split[0]);
                        name.push(split[1]);
                        price.push(split[2]);
                        quantity.push(1);}
                     }
                    
            //          $.get("shop.php",function(data){
            //     $(".items").html(data);
            // }); 
               
               
            

                 $.post("cart.php",{barcodeArray:barcode,nameArray:name,priceArray:price,quantityArray:quantity},function(data){
                    
                   $(".table-cart").html(data);
                   });


                    $.post("receipt.php",{barcodeArray:barcode,nameArray:name,priceArray:price,quantityArray:quantity},function(data){

                        $(".receipt").html(data);
                    });
                 
                }
           
            });

                         
              

           
            $(document).on('click', "#removeItem", function () {
                var remove=$(this).val();
                var ProductDetail=remove.split(".");
                
                $.post("returnToDb.php",{barcode:ProductDetail[0],quantity:ProductDetail[1]},function(){
                    
                    $('#'+ProductDetail[0]).remove(); 
                    
                    if(barcode.includes(ProductDetail[0])){
                        var existingArrayCount= barcode.length;
                        var j=0;

                        while(j<existingArrayCount){
                            if(barcode[j]===ProductDetail[0]){
                                barcode.splice(j,1);
                                price.splice(j,1);
                                name.splice(j,1);
                                quantity.splice(j,1);
                            }
                            j++;
                        }
                        //refresh cart after deleting
                        $.post("cart.php",{barcodeArray:barcode,nameArray:name,priceArray:price,quantityArray:quantity},function(data){
                    
                            $(".table-cart").html(data);

                        $.post("receipt.php",{barcodeArray:barcode,nameArray:name,priceArray:price,quantityArray:quantity},function(data){

                            $(".receipt").html(data);

                        });

                   //after removing from cart we must return data to inventory and refresh         
                    $.get("shop.php",function(data){
                    $(".items").html(data);
                    });
                    //after removing from cart we must return data to inventory and refresh end

                   });
                    }
                    
                });
        });


            
        
    });

        // $(document).on('click', ".product", function () {
               
        //     $.get("shop.php",function(data){
        //         $(".items").html(data);
        //     });
        // });
    
    
        

    </script>
</head>
<body style="background: #F1F3F4;" >

<div class="container-fluid" STYLE="margin-top:10px;">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body table-cart">
                    <table class="table table-cart" id="cart-item-table-header table">
                        <thead>
                        <tr class="active">
                            <th width="100" class="text-right"> Barcode</th>
                            <th width="200" class="text-left">Items</th>
                            <th width="120" class="text-center hidden-xs">Unit Price</th>
                            <th width="100" class="text-center">Quantity</th>
                            <th width="100" class="text-right">Total Price</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        
                        <tfoot>
                        <tr>
                            <th>Products count ( 0 )</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Sub Total</th>
                            <th>0 ksh</th>
                        </tr>
                        
                        <tr style="background:#DFF0D8;">
                            <th></th>
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
                                    <input  type="text" class="form-control col-12" id="inlineFormInputGroup" placeholder="Barcode, product name, code" >
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="container">
                        <div class="row items">
                            <!-- <div class="items"> -->
                            <?php
                                $sql = "SELECT * FROM product WHERE quantity>0";
                                $exe = $connect->query($sql);
                                while($row = $exe->fetch_assoc())
                                {
                                    $product = array($row['code'],$row['name'],$row['sp'],$row['quantity']);
                                    $image = $row['image'];

                                    ?>


                                    <button value="<?php echo $product[0].','.$product[1].','.$product[2].','.$product[3]?>" class="col-md-2 product" style="background-color:white;border:1px solid gray;margin-top:8px;margin-right:8px;" id="product">
                                        <img src="<?="10.10.168.100/$image"?>" alt="<?=$row['name']?>"  width="50px;">
                                        <small class="text-info"><?=$row['name']?></small><br>(<small><?=$row['item_quantity']?> ml</small>)
                                        <br>

                                        <small><?=$row['code']?></small>
                                    </button>
                                <?php
                                }

                            ?>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm purchase</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" id="printJS-form">
                        <p>Invoice : #<?=$trans_id?> </p>
                        <br>
                        <table class="table receipt">
                          <thead>
                          <tr>
                              <th>Item</th>
                              <th>Unit price</th>
                              <th>Qty</th>
                              <th>Total</th>
                          </tr>
                          </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </form>

                    <button type="button" onclick="printJS('printJS-form', 'html')" class="btn btn-default btn-sm">
                        Print
                    </button>
                </div>
                <div class="modal-footer">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                        <button class="btn btn-success btn-sm" type="submit" name="transaction">
                            Save transaction
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--    end modal-->
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