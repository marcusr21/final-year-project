<?php
session_start();
$search=isset($_GET['q']) ? $_GET['q'] : "";
$barcode=isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
$query=isset($_REQUEST['adQ']) ? $_REQUEST['adQ'] : "";
$tagsAdvanced= $_REQUEST['tags'];
$catAdvanced= $_REQUEST['cat'];
$start=isset($_POST['startDate']) ? $_POST['startDate'] : null;
$end=isset($_POST['endDate']) ? $_POST['endDate'] : null;

$first=$_SESSION['first'];
$current_url = $_SERVER['REQUEST_URI'];
$i=0;
include('header.php');
include('connect.php');

$startDate=date('Y-m-d', strtotime($start));
$endDate=date('Y-m-d', strtotime($end));

function advancedSearch($query, $tagsAdvanced, $catAdvanced, $startString, $endString, $conn){
  $searchResults[]=array();

  $w = array();

  //reference tags to a new array using ampersand

  //$newTags =& $tags;


  foreach( $tagsAdvanced as $tagQuery){
    $w[] = "tags.tag='$tagQuery'";
  }

  //$newCat =& $cat;


  foreach($catAdvanced as $catsQuery){
    $w[]="category.category='$catsQuery'";
  }
  if($w){
    $where=implode(' OR ', $w);
  }

  $selectStart="SELECT * FROM loan INNER JOIN loantoasset
  ON loan.loanNumber=loantoasset.loanNumber
  WHERE (plannedStart BETWEEN '$startString' AND '$endString')
  OR (plannedEnd BETWEEN '$startString' AND '$endString')";
  if($startResult=mysqli_query($conn,$selectStart)){
    while($startRow=mysqli_fetch_array($startResult)){
      $unavailableStart[]=$startRow['barcode'];
    }
  }
  else {
    echo "Error: ".$conn->error;
  }
  $selectAsset = "SELECT assets.id
  FROM assets INNER JOIN category
  ON assets.category=category.id
  INNER JOIN assettotag ON assets.id=assettotag.assetid
  INNER JOIN tags ON assettotag.tagid=tags.tagid
  WHERE MATCH (make, model, description, tags) AGAINST ('*$query*' IN BOOLEAN MODE)
  AND $where";
  $i=0;
  if($selectResult=mysqli_query($conn, $selectAsset)){
    while($selectRow=mysqli_fetch_array($selectResult)){
      $barcode[]=$selectRow[0];
    }
    $result = array_unique($barcode);
    foreach($result as $newBarcode){
      if(count($unavailableStart) > 0){
        foreach($unavailableStart as $unavailable){
          $flag=false;
          if($unavailable==$newBarcode){
            $flag=true;
          }
          else{
            $foundBarcode[$i]=$newBarcode;
          }
          $i++;
        }
      }
      else{
        $foundBarcode[]=$newBarcode;
      }
    }
  }
  else {
    echo "Error: ".$conn->error;
  }
  foreach($foundBarcode as $key){
    $sql="SELECT assets.id, make, model, description
    FROM assets
    WHERE assets.id='$key'";
    $result=mysqli_query($conn, $sql);
    while($row=mysqli_fetch_array($result)){
      $searchResult[]=array('id'=>$row['id'], 'make'=>$row['make'], 'model'=>$row['model'], 'desc'=>$row['description']);
    }
  }
  return $searchResult;
}

if($search=="" && $barcode ==""){
  $searchQuery="SELECT assets.id, make, model, tags, category.category, description, tags.tag
  FROM assets INNER JOIN category
  ON assets.category=category.id
  INNER JOIN assettotag ON assets.id=assettotag.assetid
  INNER JOIN tags ON assettotag.tagid=tags.tagid
  ORDER BY assets.id";
  if($result=mysqli_query($conn,$searchQuery))
  {
    while($row=mysqli_fetch_row($result)){
      $barcodeArray[$i]=$row[0];
      $category[$i]=$row[4];
      $tags[$i]=$row[6];
      $i++;
    }
    $tmpArr = array_unique($barcodeArray);
    $count=0;
    foreach($tmpArr as $v){
      $newArr[$count]=$v;
      $count++;
    }
    foreach($newArr as $value){
      $sqlSelect="SELECT assets.id, make, model, category.category, description
      FROM assets INNER JOIN category
      ON assets.category=category.id";
      if($results=mysqli_query($conn, $sqlSelect)){
        while($rows=mysqli_fetch_array($results)){
          $barcodeArrayResult[]=$rows[0];
          $make[]=$rows['make'];
          $model[]=$rows['model'];
          $catResult[]=$rows['category'];
          $desc[]=$rows['description'];
        }
      }
    } //close foreach loop
  } //close check on mysqli_query
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
        $sql="SELECT assets.id, make, model, category.category, description
        FROM assets INNER JOIN category
        ON assets.category=category.id
        WHERE assets.id='$value'";
        $result=mysqli_query($conn, $sql);
        while($rows=mysqli_fetch_array($result)){
          $barcode[]=$rows[0];
          $make[]=$rows['make'];
          $model[]=$rows['model'];
          $desc[]=$rows['description'];
          $catResult[]=$rows['category'];
        }
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
            $("#startDateBasket").html(json.start);
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
            $("#endDateBasket").html(json.end);
            console.log(json);
          }
        });
      }
    });

    $('#tags').select2();
    $('#cat').select2();

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
      echo 'Start Date: <div id="startDateBasket"></div>';
      echo 'End Date: <div id="endDateBasket"></div>';
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

  <div id="advancedSearch">
    <form id='advanced' method='POST' action='results.php'>
    <div class="row">
      <div class="col-md-8">
      <div class="input-group">
          <input type='text' class='form-control' id='adQ' name='adQ' placeholder='Search' />
          <span class="input-group-btn">
            <button class="btn btn-default btn-sml" type='submit'>
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="input-group">
          Start Date: <input type="text" class="form-control" id="startDate" name="startDate">
        </div>
      </div>
      <div class="col-md-4">
        <div class="input-group">
          End Date: <input type="text" class="form-control" id="endDate" name="endDate">
        </div>
      </div>
    </div>
    <div class="row">
      <div id="filter-wrapper">
            <?php
            //get all possible filter info from previous functions
            $uniqueCategory=array_unique($category);
            $uniqueTags=array_unique($tags);
            echo "<div class='col-md-4'>\n";
            echo "<div class='input-group'>\n";
            echo "Category <select name=\"cat[]\" id=\"cat\" multiple=\"multiple\">\n";
            echo "<option></option>";
            foreach($uniqueCategory as $cat){
              echo "<option value=\"$cat\">".$cat."</option>\n";
            }
            echo "</select><br/>\n";
            echo "</div>";
            echo "</div>";
            echo "<div class='col-md-4'>";
            echo "<div class='input-group'>";
            echo "Tags <select name='tags[]' id='tags' multiple>\n";
            echo "<option></option>";
            foreach($uniqueTags as $tag){
              echo "<option value='".$tag."'>".$tag."</option>\n";
            }
            echo "</select><br/>\n";
            echo "</div>";
            echo "</div>";
            echo "<input type='hidden' id='url' value='".$current_url."' />\n";
            echo "<input type='hidden' id='name' name='name' value='advanced' />\n";
            echo "<input type='hidden' id='query' name='query' value='".$search."' />\n";
            echo "<input type='submit' value='Search!' class='btn btn-primary btn-sml'>\n";
            echo "<input type='hidden' id='url' value='".$current_url."' />\n";
            ?>
        </div>
    </form>
  </div>

  <div id="results">
    <h3>Results</h3>
  <?php
  if($search=="" && $barcode == "" && $query==""){
    for($count=0; $count < count($barcodeArray); $count++){
        echo "<div class='form-group'>\n";
        echo "<form name='add' method='POST' action='basket_update.php'>\n";
        echo "Make: ".$make[$count]."<br> Model: ".$model[$count]."<br>\n";
        echo "Category: ".$catResult[$count]."<br>\n";
        echo "Description: ".$desc[$count]."<br>\n";
        echo "<input type='submit' value='Add to Basket' class='btn btn-primary btn-sml'>\n";
        echo "<input type='hidden' name='barcode' value='".$barcodeArray[$count]."' />\n";
        echo "<input type='hidden' name='url' value='".$current_url."' />\n";
        echo "<input type='hidden' name='type' value='add' />\n";
        echo "</form>\n";
        echo "</div>\n";
      }
    }
  elseif($barcode!="" && $query==""){
    $searchQuery="SELECT assets.id, make, model, tags, category.category, description FROM assets INNER JOIN category
    ON assets.category=category.id WHERE assets.id=$barcode";
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
  if($search!="" && $query==""){
    for($count=0;$count < count($barcode); $count++)
    {
            echo "<div class='form-group'>\n";
            echo "<form method='post' action='basket_update.php'>\n";
            echo "Make: ".$make[$count]."<br> Model: ".$model[$count]."<br>\n";
            echo "Category: ".$catResult[$count]."<br>\n";
            if(isset($_SESSION['products'])){
              $flag=false;
              foreach($_SESSION['products'] as $itemArray){
                if($itemArray['barcode']==$barcode[$count]){
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
            echo "Description: ".$desc[$count]."<br>\n";
            echo "<input type='hidden' name='barcode' value='".$barcode[$count]."' />\n";
            echo "<input type='hidden' name='url' value='".$current_url."' />\n";
            echo "<input type='hidden' name='type' value='add' />\n";
            echo "</form>\n";
            echo "</div>\n";
          }
  }

  if($query != ""){
    $searchResult=advancedSearch($query, $tagsAdvanced, $catAdvanced, $startDate, $endDate, $conn);
    foreach($searchResult as $result){
      echo "<div class='form-group'>\n";
      echo "<form method='post' action='basket_update.php'>\n";
      echo "Make: ".$result['make']."<br> Model: ".$result['model']."<br>\n";
      if(isset($_SESSION['products'])){
        $flag=false;
        foreach($_SESSION['products'] as $itemArray){
          if($itemArray['barcode']==$barcode[$count]){
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
      echo "Description: ".$result['description']."<br>\n";
      echo "<input type='hidden' name='barcode' value='".$result['id']."' />\n";
      echo "<input type='hidden' name='url' value='".$current_url."' />\n";
      echo "<input type='hidden' name='type' value='add' />\n";
      echo "</form>\n";
      echo "</div>\n";
    }
  }
  ?>
  </div>
</div>
<?php
include('footer.php');
?>
