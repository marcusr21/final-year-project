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
    <input type="text" name="search" id="search" text="search">
  </form>
</div>
<div id="myBookings">
  <?php
  ?>
</div>

<?php
include('footer.php');
?>
