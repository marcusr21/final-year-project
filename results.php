<?php
session_start();
$search=$_REQUEST['q'];
?>
<?php
$i=0;
include('header.php');
include('connect.php');
?>
<script>
  $(document).ready(function(){
    $(function() {
      $("#datepicker").datepicker();
    });
    $(function() {
      $("#endDatepicker").datepicker();
    });
    $("#datepicker").on("blur", function(){
      var datepickerValue = datepicker.value;
    });

    $('#resultFilter').affix({
      offset: {
        top: 100,
        bottom: 100
      }
    });
});
</script>
<div class="container">
  <div class="resultFilter">
    <p>Test data</p>
    Start Date: <input type="text" id="datepicker">
    End Date: <input type="text" id="endDatepicker">
    <?php

    //ajax retrieve from jquery datepicker.value
    $date=''
    ?>
  </div>
</div>

<div class="container">
<?php
if($search==""){
  $searchQuery="SELECT barcode, make, model, tags, category.category, description FROM assets INNER JOIN category
  ON assets.category=category.id";
  if($result=mysqli_query($conn,$searchQuery))
  {
    while($row=mysqli_fetch_row($result)){
      $barcode[i]=$row[0];
      $make[i] = $row[1];
      $model[i]=$row[2];
      $category[i]=$row[4];
      $desc[i]=$row[5];
      echo "<div>";
      echo "Make: ".$make[i]."<br> Model: ".$model[i]."<br>";
      echo "Category: ".$category[i]."<br>";
      echo "Description: ".$desc[i]."<br>";
      echo "</div>";
      echo "<div class='button'>";
      echo "<a class='btn btn-default btn-sml' href='basket_update.php?barcode=".$barcode[i]."&start=".$start."&end=".$end."'>Add to basket</a>";
      $i++;
    }
  }
  else {

  }
}
?>
</div>
<div class="container">
  <div class="shopping-basket">
    <h3>Your Basket</h3>
    <?php
    if(isset($_SESSION['products'])){
      $total =0;
      echo '<ol>';
      foreach($_SESSION['products'] as $item){
        echo '<li class=cart-item>';
        echo '<span class="remove-item"><a href="basket_update.php?remove='.$item["barcode"].'&returnurl='.$current_url.'"</a></span>';
        echo '<strong>'.$item["make"].' '.$item["model"].'</strong>';
        echo '<div class="startDate">Start Date: '.$item["start"].'</div>';
        echo '<div class="endDate>"End Date: '.$item["end"].'</div>';
        echo '</li>';
      }
      echo '</ol>';
      echo '<span class="check-out"><a class="btn btn-default btn-sml" href="view_basket.php">Check out</a></span>';
    }
    else {
      echo 'Your basket is empty';
    }
    ?>
<?php
include('footer.php');
?>
