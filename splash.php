<?php
session_start();
//gap to start session
?>
<?php
include('header.php');
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
  /*If username matches and loan is still outstanding
  then return the information here with all relevant information
  SQL check username & actualreturn = blank*/
  ?>
</div>

<?php
include('footer.php');
?>
