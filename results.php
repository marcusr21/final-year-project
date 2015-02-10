<?php
session_start();
$search=$_REQUEST['q'];
?>
<?php
$current_url = $_SERVER['REQUEST_URI'];
$i=0;
include('header.php');
include('connect.php');
?>
<script>
  $(document).ready(function(){
    $('#startDate').datepicker({
      defaultDate: "+1w",
      numberOfMonths: 1,
      dateFormat: "dd-mm-yy",
      onClose: function(selectedDate) {
        $('#endDate').datepicker("option", "minDate", selectedDate);
        var startDateVal=$('#startDate').datepicker("getDate");
        $.ajax({
          type: 'POST',
          url: 'ajax.php',
          data: "start=" + startDateVal,
          dataType: 'json',
          success: function(json)
          {
            $("#start").val(json.start);
            console.log(json);
          }
        });
      }
    });
    $('#endDate').datepicker({
      defaultDate: "1+w",
      numberOfMonths: 1,
      dateFormat: "dd-mm-yy",
      onClose: function(selectedDate) {
        $('#startDate').datepicker("option", "maxDate", selectedDate);
        var endDateVal=$('#endDate').datepicker("getDate");
        //var endDataString = "end=" + endDateVal;
        $.ajax({
          type: 'POST',
          url: 'ajax.php',
          data: "end=" + endDateVal,
          dataType: 'json',
          success: function(json)
          {
            $("#end").val(json.end);
            console.log(json);
          }
        });
      }
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
  <div class="data">
  </div>
  <div class="resultFilter">
    Start Date: <input type="text" id="startDate">
    End Date: <input type="text" id="endDate">
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
      echo "<div class='container'>";
      echo "<form method='post' action='basket_update.php'>";
      echo "Make: ".$make[i]."<br> Model: ".$model[i]."<br>";
      echo "Category: ".$category[i]."<br>";
      echo "Description: ".$desc[i]."<br>";
      echo "<button class='btn btn-primary btn-sml'>Add to basket</button>";
      echo "<input type='hidden' name='barcode' value='".$barcode[i]."' />";
      echo "<input type='hidden' name='url' value='".$current_url."' />";
      echo "<input type='hidden' name='start' id='start' value=''>";
      echo "<input type='hidden' name='end' id='end' value=''>";
      echo "<input type='hidden' name='type' value='add' />";
      echo "</form>";
      echo "</div>";
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
        echo '<strong>'.$item["make"].' '.$item["model"].' </strong>';
        echo '<span class="errorMessage">'.$item["message"].'</span>';
        echo '<div class="startDate">Start Date: '.$item["start"].'</div>';
        echo '<div class="endDate">End Date: '.$item["end"].'</div>';
        echo '<a class="btn btn-danger btn-sml" href="basket_update.php?remove='.$item["barcode"].'&returnurl='.$current_url.'">Remove this item</a>';
        echo '</li>';
      }
      echo '</ol>';
      echo '<a href="basket_update.php?remove=all&returnurl='.$current_url.'">Remove all items</a>';
      echo '<span class="check-out"><a class="btn btn-default btn-sml" href="basket.php?returnurl='.$current_url.'">Check out</a></span>';
    }
    else {
      echo 'Your basket is empty';
    }
    ?>
<?php
include('footer.php');
?>
