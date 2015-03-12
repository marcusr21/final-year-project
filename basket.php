<?php
session_start();
include('connect.php');
include('header.php');
if(isset($_SESSION['products'])){
  $return_url=$_GET['returnurl'];
  $current_url=$_SERVER['REQUEST_URI'];
  $totalItems=0;

  echo "<div class='container'>";
  echo "<form method='post' action='sendRequest.php' name='productView'>";
  echo "<ul>";

  foreach($_SESSION['products'] as $bask_item) {
    //var_dump($bask_item);
    $barcode=$bask_item['barcode'];
    $query="SELECT make, model, description FROM assets WHERE id='$barcode' LIMIT 1";
    if($result=mysqli_query($conn, $query)){
      while($row=mysqli_fetch_array($result)){
        echo '<li>';
        echo '<a href="basket_update.php?remove='.$barcode.'&returnurl='.$current_url.'">Remove this item</a>';
        echo '<div class="product-info">';
        echo '<h3>'.$row[0].'</h3> Barcode: '.$barcode;
        echo 'Make: '.$row[1];
        echo 'Description: '.$row[2];
        echo '</div>';
        echo '</li>';

        echo '<input type="hidden" name="barcode['.$totalItems.']" value="'.$barcode.'" />';
        echo '<input type="hidden" name="make['.$totalItems.']" value="'.$row[0].'" />';
        echo '<input type="hidden" name="model['.$totalItems.']" value="'.$row[1].'" />';
        $totalItems++;
      }
    }
  }
  echo '</ul>';
  echo 'Please enter the reasons for this loan request below: </br>';
  echo '<textarea name="reasons" class="form-control" maxlength="200"> </textarea>';
  echo '<input type="submit" class="btn btn-primary" value="Checkout" />';
  echo '</form>';
  echo '<div class="container">';
}
?>
