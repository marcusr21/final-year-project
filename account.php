<?php
session_start();
include('connect.php');
include('header.php');
$uid=$_SESSION['uid'];

$get="SELECT * FROM user where UID='$uid'";
if($result=mysqli_query($conn, $get)){
  while($row=mysqli_fetch_array($result)){
    $first=$row['firstname'];
    $surname=$row['surname'];
    $email=$row['email'];
    $username=$row['username'];
    $storedHash=$row['password'];
  }
}
?>

<script>
$(document).ready(function(){
  $("#details").on('click', function(){
    $("#changeDetails").show();
    $("#updatePassword").hide();
  });

  $("#password").on('click', function(){
    $("#updatePassword").show();
    $("#changeDetails").hide();
  })

  $("#repeatPass").on('input', function(){
    var input=$(this);
    var origin=$("#originPass");
    if(origin.val()==input.val()){input.removeClass("invalid").addClass("valid");}
    else{input.removeClass("valid").addClass("invalid");}
  });

  $("#change").click(function(e){
    if($("#repeatPass").hasClass("invalid")){
      alert("Please ensure passwords match");
      e.preventDefault(e);
    }
  });
});
</script>

<?php
$passwordStatus=$_GET['password'];
if(isset($passwordStatus)){
  echo "Password update ".$passwordStatus."<br>\n";
}
?>

<div class='container'>
  <h2>Manage Account</h2>
  <p>Below you can manage your account and change any details</p>
  <div class="option">
    <h3><a href="#" id='details'>Change Details</a></h3>
  </div>
  <div class='option'>
    <h3><a href="#" id="password">Change Password</a></h3>
  </div>

  <form id="changeDetails" action="management/updateUser.php" method="POST" style="visibility:hidden">
    <label for="username">Username</label><input type='text' name='user' value=<?php echo $username ?> />
    <label for="firstname">Firstname</label><input type='text' name="first" value=<?php echo $first ?> />
    <label for="surnameLabel">Surname</label><input type='text' name='surname' value=<?php echo $surname ?> />
    <label for="emailLabel">Email</label><input type='text' name='email' value=<?php echo $email ?> />
    <button type='submit' class='btn btn-primary btn-sml'>Update Details</button>
  </form>

  <form id="updatePassword" action="scripts/changePassword.php" method="POST" style="visibility:hidden">
    <label for="oldPassLabel">Current Password</label><input type='password' name='oldPass' id='oldPass' />
    <label for="newPass">New Password</label><input type='password' name='originPass' id='originPass' />
    <label for="repeat">Repeat Password</label><input type='password' name='checkPassword' id='repeatPass' />
    <input type='hidden' name='type' value='change' />
    <button id='change' type='submit' class='btn btn-primary btn-sml'>Change Password</button>
  </form>

</div>

<?php
include('footer.php');
?>
