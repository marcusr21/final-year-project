<?php
session_start();
$search=$_REQUEST['q'];
?>
<?php
$i=0;
include('header.php');
?>
<script>
  $(document).ready(function(){
    $(function() {
      $("#datepicker").datepicker();
    });
})
</script>
<div class="resultFilter">
  Date: <input type="text" id="datepicker">
  <?php

  //ajax retrieve from jquery datepicker.value
  $date=''
  ?>
</div>

<?php
if($search==""){
  $searchQuery="SELECT barcode, make, model, tags, category, description FROM assets";
  if($result=mysqli_query($conn,$searchQuery))
  {
    while($row=mysqli_fetch_row($result)){
      $barcode[i]=$row[0];
      $make[i] = $row[1];
      $model[i]=$row[2];
      $category[i]=$row[4];
      $desc[i]=$row[5];
      echo "<div>";
      echo "Make: ".$make[i]." Model: ".$model[i]."<br>";
      echo "Category: ".$category[i]."<br>";
      echo "Description: ".$desc[i]."<br>";
      echo "</div>";
      echo "<div class='button'>";
      echo "<a href='details.php?barcode=".$barcode[i]."&date=".$timestamp."'>Loan this item";
      $i++;
    }
  }
}
?>
