<?php
session_start();
$user = $_SESSION['user'];
$uid = $_SESSION['uid'];
//gap to start session
?>
<?php
include('header.php');
require_once('connect.php');
echo "Welcome back ".$_SESSION["first"]."<br>";
?>
<script>
  $(document).ready(function(){
    $('input.typeahead').typeahead({
      name: 'search',
      remote: 'search.php?q=%QUERY',
      limit: 10
    });
  });
</script>
<div id="manageBooking">
  <a href="bookings.php">Manage Your Bookings</a>
</div>
<div id="editAccount">
  <a href="account.php">Edit your Account</a>
</div>
    <input type="text" name="search" id="search" class="typeahead tt-query" placeholder="Search">
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
      FROM loantoasset INNER JOIN assets ON loantoasset.barcode = assets.barcode
      WHERE loanNumber='$loanNumber'";
      $assetResult=mysqli_query($conn, $sql);
      while($assetRow=mysqli_fetch_array($assetResult)){
        echo "Make: ".$assetRow['make']." Model: ".$assetRow['model']."<br/>\n";
      }
      echo "</div>";
    }
    mysqli_free_result($result);
  }
  else {
    echo "Error ". $conn->error;
  }
  /*If username matches and loan is still outstanding
  then return the information here with all relevant information
  SQL check username & actualreturn = blank*/
  ?>
</div>

<?php
include('footer.php');
?>
