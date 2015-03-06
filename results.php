<?php
session_start();
$search=$_POST['q'];
$barcode=$_REQUEST['id'];
$first=$_SESSION['first'];
?>
<?php
$current_url = $_SERVER['REQUEST_URI'];
$i=0;
include('header.php');
include('connect.php');

if($search=="" && $barcode ==""){
  $searchQuery="SELECT assets.id, make, model, tags, category.category, description FROM assets INNER JOIN category
  ON assets.category=category.id ORDER BY assets.id";
  if($result=mysqli_query($conn,$searchQuery))
  {
    while($row=mysqli_fetch_row($result)){
      $barcodeArray[$i]=$row[0];
      $make[$i] = $row[1];
      $model[$i]=$row[2];
      $category[$i]=$row[4];
      $desc[$i]=$row[5];
      $tags[$i]=explode(", ", $row[3]);
      $i++;
    }
  }
}
else{
  echo "Error: ".$conn->error;
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

    //$('#tags').select2();

        /*$('#shoppingBasket').affix({
          offset: {
            top: $('#results').offset().top
          }
        });*/


    $('#resultFilter').affix({
      offset: { top: $('#results').offset().top }
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
        //$tagsExplode=explode(" , ", $tags);
        //$uniqueTags=array_unique($tags);
        $keys = array_keys($tags);
        for($count=0; $count < count($tags[$keys[0]]); $count++){
          $data=array();
          foreach($tags as $key => $value){
            $data[$key] = $value[$count];
          }
        }
        $uniqueTags=array_unique($data);
        foreach($uniqueCategory as $cat){
          echo "<input type='radio' name='category' value='".$cat."'>".$cat."</br>\n";
        }
        echo "Tags <select id='tags' multiple>\n";
        echo "<option></option>";
        foreach($uniqueTags as $tag){
          echo "<option value='".$tag."'>".$tag."</option>\n";
        }
        echo "</select><br/>\n";
        echo "<input type='submit' value='Search!' class='btn btn-primary btn-sml'>";
        ?>
      </form>
    </div>
  </div>

  <div class="shoppingBasket">
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
  $searchQuery="SELECT assets.id, make, model, tags, category.category, description FROM assets INNER JOIN category
  ON assets.category=category.id WHERE assets.id='$barcode'";
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
if($search!=""){
  $selectResults="SELECT assets.id, make, model, category.category, description, MATCH (make, model, description, tags) AGAINST ('*$search*' IN BOOLEAN MODE) as relevant
  FROM assets INNER JOIN category
  ON assets.category=category.id
  WHERE MATCH (make, model, description, tags) AGAINST ('*$search*' IN BOOLEAN MODE)
  ORDER BY relevant DESC";
  if($results=mysqli_query($conn, $selectResults)){
    while($row=mysqli_fetch_array($results)){
      echo "<div class='form-group'>\n";
      echo "<form method='post' action='basket_update.php'>\n";
      echo "Make: ".$row['make']."<br> Model: ".$row['model']."<br>\n";
      echo "Category: ".$row['category']."<br>\n";
      echo "Description: ".$row['description']."<br>\n";
      echo "<button class='btn btn-primary btn-sml'>Add to basket</button>\n";
      echo "<input type='hidden' name='barcode' value='".$row['id']."' />\n";
      echo "<input type='hidden' name='url' value='".$current_url."' />\n";
      echo "<input type='hidden' name='start' id='start' value=''>\n";
      echo "<input type='hidden' name='end' id='end' value=''>\n";
      echo "<input type='hidden' name='type' value='add' />\n";
      echo "</form>\n";
      echo "</div>\n";
    }
  }
  else{
    echo "Error: ".$conn->error;
  }
}
?>
</div>

</div>
<?php
include('footer.php');
?>
