<?php
session_start();
$user = $_SESSION['user'];
//gap to start session
?>
<?php
include('header.php');
require_once('connect.php');
echo "Welcome back ".$_SESSION["first"]."<br>";
?>

<div id="manageBooking">
  <a href="bookings.php">Manage Your Bookings</a>
</div>
<div id="editAccount">
  <a href="account.php">Edit your Account</a>
</div>
<div class="search">
  <form>
    <input type="text" name="search" id="search" value="Search">
  </form>
</div>
<div id="myBookings">
  <h3>View your current bookings</h3>
  <?php
  $uidQuery="SELECT UID from user WHERE username='$user'";
  if($result=mysqli_query($conn,$uidQuery)){
    while($row=mysqli_fetch_row($result)){
      $uid = $row;
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
