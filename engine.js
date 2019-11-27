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

            //phone cart count
            var total=0;
            for(var c in quantity) { total += quantity[c]; }
            $(".phoneCount").html(total);
            //phone cart count end

           });


            $.post("receipt.php",{barcodeArray:barcode,nameArray:name,priceArray:price,quantityArray:quantity},function(data){

                $(".receipt").html(data);

            //phone cart count
            var total=0;
            for(var c in quantity) { total += quantity[c]; }
            $(".phoneCount").html(total);
            //phone cart count end
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

            //phone cart count
            var total=0;
            for(var c in quantity) { total += quantity[c]; }
            $(".phoneCount").html(total);
            //phone cart count end


                $.post("receipt.php",{barcodeArray:barcode,nameArray:name,priceArray:price,quantityArray:quantity},function(data){

                    $(".receipt").html(data);

            //phone cart count
            var total=0;
            for(var c in quantity) { total += quantity[c]; }
            $(".phoneCount").html(total);
            //phone cart count end

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
