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
    $('#search').on('input', function() {
          var searchKeyword = $(this).val();
          if (searchKeyword.length >= 3) {
            $.post('search.php', { keywords: searchKeyword }, function(data) {
              $('ul#content').empty()
              $.each(data, function() {
                $('ul#content').append('<li><a href="results.php?id=' + this.id + '">' + this.make + ' ' + this.model + '</a></li>');
              });
            }, "json");
          }
        });
  });
</script>
<div id="manageBooking">
  <a href="bookings.php">Manage Your Bookings</a>
</div>
<div id="editAccount">
  <a href="account.php">Edit your Account</a>
</div>
<div id='searchDiv'>
  <form action='results.php' method='POST'>
    <input type="text" id="search" placeholder="Search">
  </form>
  <ul id='content'></ul>
</div>
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
  ?>
</div>

<?php
include('footer.php');
?>
