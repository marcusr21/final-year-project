<?php
session_start();
$user = $_SESSION['user'];
$uid = $_SESSION['uid'];
//gap to start session
?>
<?php
include('header.php');
require_once('connect.php');
?>
<div class="container">
<div id="myBookings">
  <h3>View your current bookings</h3>
  <?php
  $sql="SELECT loanNumber, count, actualStart, plannedEnd
  FROM loan
  WHERE UID='$uid' AND actualEnd IS NULL AND actualStart IS NOT NULL";
  if($result=mysqli_query($conn,$sql)){
    while($row=mysqli_fetch_array($result)){
      echo "<div class='container'>";
      echo "Loan Number: ".$row['loanNumber']."<br/>\n";
      echo "Start: ".$row['actualStart']." End: ".$row['plannedEnd']."<br/>\n";
      $sql="SELECT loantoasset.barcode, make, model
      FROM loantoasset INNER JOIN assets ON loantoasset.barcode = assets.id
      WHERE loanNumber='$loanNumber'";
      $assetResult=mysqli_query($conn, $sql);
      while($assetRow=mysqli_fetch_array($assetResult)){
        echo "Make: ".$assetRow['make']." Model: ".$assetRow['model']."<br/>\n";
      }
      $resultCount=mysqli_num_rows($assetResult);
      if($resultCount = 0){
        echo "<div class='container'>";
        echo "<p>you currently have no assets on loan</p>";
      }
      echo "</div>";
    }
    mysqli_free_result($result);
  }
  else {
    echo "Error ". $conn->error;
  }
  ?>
</div>
</div>
<?php
include('footer.php');
?>
