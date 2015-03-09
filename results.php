<?php
session_start();
$search=isset($_GET['q']) ? $_GET['q'] : "";
$barcode=isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

$first=$_SESSION['first'];
$current_url = $_SERVER['REQUEST_URI'];
$i=0;
include('header.php');
include('connect.php');
//require_once('search.php');

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
      $i++;
    }
  }
}
?>
<script>
  $(document).ready(function(){

    $('#startDate').datepicker({
      defaultDate: "1+w",
      numberOfMonths: 1,
      dateFormat: "dd-mm-yy",
      minDate: 0,
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
      defaultDate: "2+w",
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

    $('#tags').select2();

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
  <div class="shoppingBasket">
    <h3>Your Basket</h3>
    <?php
    if(isset($_SESSION['products'])){
      $total=0;
      echo '<div class="startDate">Start Date: '.$start.'</div>';
      echo '<div class="endDate">End Date: '.$end.'</div>';
      echo '<ol>';
      foreach($_SESSION['products'] as $item){
        echo '<li class=cart-item>';
        echo '<strong>'.$item["make"].' '.$item["model"].' </strong>';
        echo '<span class="errorMessage">'.$item["message"].'</span>';
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
      echo "<input type='hidden' name='type' value='add' />\n";
      echo "</form>\n";
      echo "</div>\n";
      $i++;
    }
  }
}
if($search!=""){
  $selectResults="SELECT assets.id, make, model, category.category, description, tags.tag, MATCH (make, model, description, tags) AGAINST ('*$search*' IN BOOLEAN MODE) as relevant
  FROM assets INNER JOIN category
  ON assets.category=category.id
  INNER JOIN assettotag ON assets.id=assettotag.assetid
  INNER JOIN tags ON assettotag.tagid=tags.tagid
  WHERE MATCH (make, model, description, tags) AGAINST ('*$search*' IN BOOLEAN MODE)
  ORDER BY relevant DESC";
  if($results=mysqli_query($conn, $selectResults)){
    $i=0;
    while($row=mysqli_fetch_array($results)){
      $category[$i]=$row['category'];
      $tags[$i]=$row['tag'];
      $id[]=$row['id'];
      $i++;
    }
      $tmpArr = array_unique($id);
      foreach($tmpArr as $v){
        $newArr[$count]=$v;
        $count++;
      }
      foreach($newArr as $value){
        $sql="SELECT * FROM assets INNER JOIN category
        ON assets.category=category.id
        WHERE assets.id='$value'";
        $result=mysqli_query($conn, $sql);
        while($rows=mysqli_fetch_array($result)){
          $barcode[]=$rows[0];
          echo "<div class='form-group'>\n";
          echo "<form method='post' action='basket_update.php'>\n";
          echo "Make: ".$rows['make']."<br> Model: ".$rows['model']."<br>\n";
          echo "Category: ".$rows['category']."<br>\n";
          if(isset($_SESSION['products'])){
            $flag=false;
            foreach($_SESSION['products'] as $itemArray){
              if($itemArray['barcode']==$rows[0]){
                $flag=true;
                echo '<a class="btn btn-danger btn-sml" href="basket_update.php?remove='.$itemArray["barcode"].'&returnurl='.$current_url.'">Remove this item</a><br/>';
              }
            }
            if($flag==false){
              echo "<button class='btn btn-primary btn-sml'>Add to basket</button><br/>\n";
            }
          }
          else{
            echo "<button class='btn btn-primary btn-sml'>Add to basket</button><br/>\n";
          }
          echo "Description: ".$rows['description']."<br>\n";
          echo "<input type='hidden' name='barcode' value='".$rows[0]."' />\n";
          echo "<input type='hidden' name='url' value='".$current_url."' />\n";
          echo "<input type='hidden' name='type' value='add' />\n";
          echo "</form>\n";
          echo "</div>\n";
        }
    }
  }
  else{
    echo "Error: ".$conn->error;
  }
}
?>
</div>
<div id="filter-wrapper">
  <div id="resultFilter" data-spy="affix" class="navbar">
    Start Date: <input type="text" id="startDate">
    End Date: <input type="text" id="endDate">
    <form id='filters' name='filters' method="POST" action="search.php">
      <?php
      //get all possible filter info from previous functions
      $uniqueCategory=array_unique($category);
      $uniqueTags=array_unique($tags);
      foreach($uniqueCategory as $cat){
        echo "<input type='radio' name='category' value='".$cat."'>".$cat."</br>\n";
      }
      echo "Tags <select name='tags[]' id='tags' multiple>\n";
      echo "<option></option>";
      foreach($uniqueTags as $tag){
        echo "<option value='".$tag."'>".$tag."</option>\n";
      }
      echo "</select><br/>\n";
      echo "<input type='hidden' id='url' value='".$current_url."' />\n";
      echo "<input type='hidden' id='name' name='name' value='advanced' />\n";
      echo "<input type='hidden' id='query' name='query' value='".$q."' />\n";
      echo "<input type='submit' value='Search!' class='btn btn-primary btn-sml'>\n";
      ?>
    </form>
  </div>
</div>

</div>
<?php
include('footer.php');
?>
