<?php
 $connect = mysqli_connect("localhost", "root", "", "pos_inventory"); 

 if(isset($_POST["query"]))  
 {  
      $output = '';  
      $query = "SELECT * FROM product WHERE code LIKE '%".$_POST["query"]."%'";  
      $result = mysqli_query($connect, $query);  
      $output = '<ul class="list-unstyled ulkk">';  
      if(mysqli_num_rows($result) > 0)  
      {  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '<li class="kk">'.$row["code"].'</li>';  
           }  
      }  
      else  
      {  
           $output .= '<li class="kk">Barcode Not Found</li>';  
      }  
      $output .= '</ul>';  
      echo $output;  
 }

?>