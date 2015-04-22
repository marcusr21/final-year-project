<?php
include('connect.php');
include('header.php');
?>

<script>
  $(document).ready(function(){
    $("#checkPassword").on('input', function(){
      var input=$(this);
      var origin=$("#newPassword");
      if(origin.val()==input.val()){input.removeClass("invalid").addClass("valid");}
      else{input.removeClass("valid").addClass("invalid");}
      //check whether passwords math
    });

    $("#change").click(function(e){
      if($("#checkPassword").hasClass("invalid")){
        alert("Please ensure passwords match");
        e.preventDefault(e);
        //prevent form submitting if passwords do not match
      }
    });
  });
</script>

<?php
$token=$_GET['token'];

if(isset($_GET['token'])){
  echo "<div class='container'>\n";
  echo "<form name='reset' action='scripts/changePassword.php' method='POST'>\n";
  echo "New Password: <input type='password' id='newPassword' />\n";
  echo "Repeat Password: <input type='password' name='checkPassword' id='checkPassword' />\n";
  echo "<input type='hidden' name='value' id='value' value='".$token."' />\n";
  echo "<input type='hidden' id='type' name='type' value='reset' />\n";
  echo "<button type='submit' id='change' class='btn btn-default btn-sml'>Change Password</button>\n";
  echo "</form>\n";
  echo "</div>\n";
}
?>
