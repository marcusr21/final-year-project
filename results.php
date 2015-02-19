<?php
session_start();
$search=$_REQUEST['q'];
$barcode=$_REQUEST['id'];
$first=$_SESSION['first'];
?>
<?php
$current_url = $_SERVER['REQUEST_URI'];
$i=0;
include('header.php');
include('connect.php');
echo "<div class='container'>";
echo "Welcome back ".$first;
echo "</div>";
if($search=="" && $barcode ==""){
  $searchQuery="SELECT barcode, make, model, tags, category.category, description FROM assets INNER JOIN category
  ON assets.category=category.id";
  if($result=mysqli_query($conn,$searchQuery))
  {
    while($row=mysqli_fetch_row($result)){
      $barcodeArray[$i]=$row[0];
      $make[$i] = $row[1];
      $model[$i]=$row[2];
      $category[$i]=$row[4];
      $desc[$i]=$row[5];
      $tags[$i]=$row[3];
      $i++;
    }
  }
}
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
          offset: { top: $('#results').offset().top }
        });

        $('#shopping-basket').affix({
          offset: {
            top: $('#results').offset().top
          }
        });
});
</script>
<div class="container">
  <div id="filter-wrapper">
    <div id="resultFilter" data-spy="affix" class="navbar">
      Start Date: <input type="text" id="startDate">
      End Date: <input type="text" id="endDate">
      <form id='filters' name='filters'>
        <?php
        //get all possible filter info from previous functions
        $uniqueCategory=array_unique($category);
        foreach($uniqueCategory as $cat){
          echo "<input type='radio' name='category' value='".$cat."'>".$cat;
        }
        echo "<input type='submit' value='Search!' class='btn btn-primary btn-sml'>";
        ?>
      </form>
    </div>
  </div>

  <div id="results">
<?php
if($search=="" && $barcode == ""){
  for($count=0; $count < count($barcodeArray); $count++){
      echo "<div class='form-group'>\n";
      echo "<form name='add' method='POST' action='basket_update.php'>\n";
      echo "Make: ".$make[$count]."<br> Model: ".$model[$count]."<br>\n";
      echo "Category: ".$category[$count]."<br>\n";
      echo "Description: ".$desc[$count]."<br>\n";
      echo "<input type='submit' value='Add to Basket' class='btn btn-primary btn-sml'>\n";
      echo "<input type='hidden' name='barcode' value='".$barcodeArray[$count]."' />\n";
      echo "<input type='hidden' name='url' value='".$current_url."' />\n";
      echo "<input type='hidden' name='start' id='start' value='' />\n";
      echo "<input type='hidden' name='end' id='end' value='' />\n";
      echo "<input type='hidden' name='type' value='add' />\n";
      echo "</form>\n";
      echo "</div>\n";
      $i++;
    }
  }
elseif($barcode!=""){
  $searchQuery="SELECT barcode, make, model, tags, category.category, description FROM assets INNER JOIN category
  ON assets.category=category.id WHERE barcode='$barcode'";
  if($result=mysqli_query($conn,$searchQuery))
  {
    while($row=mysqli_fetch_row($result)){
      $barcode[$i]=$row[0];
      $make[$i] = $row[1];
      $model[$i]=$row[2];
      $category[$i]=$row[4];
      $desc[$i]=$row[5];
      echo "<div class='form-group'>\n";
      echo "<form method='post' action='basket_update.php'>\n";
      echo "Make: ".$make[$i]."<br> Model: ".$model[$i]."<br>\n";
      echo "Category: ".$category[$i]."<br>\n";
      echo "Description: ".$desc[$i]."<br>\n";
      echo "<button class='btn btn-primary btn-sml'>Add to basket</button>\n";
      echo "<input type='hidden' name='barcode' value='".$barcode[$i]."' />\n";
      echo "<input type='hidden' name='url' value='".$current_url."' />\n";
      echo "<input type='hidden' name='start' id='start' value=''>\n";
      echo "<input type='hidden' name='end' id='end' value=''>\n";
      echo "<input type='hidden' name='type' value='add' />\n";
      echo "</form>\n";
      echo "</div>\n";
      $i++;
    }
  }
}
?>
</div>
</div>
  <div id="shopping-basket" data-spy="affix" class="navbar">
    <h3>Your Basket</h3>
    <?php
    if(isset($_SESSION['products'])){
      $total=0;
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
