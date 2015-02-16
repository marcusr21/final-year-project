<?php
session_start();
include('connect.php');
include('header.php');
?>
<div class='container'>
  <h3>Below you will find the details for the loan</h3>
  <form action='scripts/checkoutUpdate.php' method='POST'>
  <?php
  $loanNumber=isset($_POST['loanNumber']);
  $plannedStart=strtotime(isset($_POST['plannedStart']));
  $plannedEnd=isset($_POST['plannedEnd']);
  $todayDate=strtotime(date("Y-m-d"));
  $actualDate=date("Y-m-d");

  $sql="SELECT loantoasset.barcode, make, model
  FROM loantoasset INNER JOIN assets ON loantoasset.barcode = assets.barcode
  WHERE loanNumber='$loanNumber'";
  if($result=mysqli_query($conn, $sql)){
    while($row=mysqli_fetch_array($result)){
      echo "Barcode: ".$row[0]."<br/>\n";
      echo "Make: ".$row[1]." Model: ".$row[2]."<br/>\n";
    }
  }
  if($todayDate!=$plannedStart){
    echo "Please write below, the reasons for the late start of the loan<br/>\n";
    echo "<textarea name='dateNotes' maxlength='200'></textarea><br/>\n";
  }
  echo "Any additional notes: <br/>\n";
  echo "<textarea name='notes' maxlength='200'></textarea><br/>\n";
  echo "<input type ='hidden' value='".$loanNumber."' name='loanNumber' />\n";
  echo "<input type='hidden' value='".$actualDate."' name='date' />\n";
  echo "<input type='submit' value='Checkout' class='btn btn-primary btn-sml' />\n";
  ?>
  </form>
</div>
