<?php
session_start();
$uid = $_SESSION['uid'];
$path = $_SERVER['DOCUMENT_ROOT'];
$connectPath .= $path;
$connectPath .= "/connect.php";
$headerPath .= $path;
$headerPath .= "/header.php";
include($connectPath);
include($headerPath);

if(isset($_REQUEST['type'])){
  echo $_REQUEST['id']." has been ".$_REQUEST['type'];
}
?>
<script>
$(document).ready(function(){
  $("#formSelect").on("change", function() {
      $("#" + $(this).val()).show().siblings().hide();
      $('#formShow').show();
  })

  $('#editSearch').on('input', function(){
    $('#editContent').show();
    var searchKeyword= $(this).val();
    $.post('searchUser.php', {keywords: searchKeyword}, function(data) {
      $('#editContent').empty();
      $.each(data, function(){
        $('#editContent').append('<a href="#" class="link" data-linkid="'+this.uid+'">'+this.firstname+' '+this.surname+'</a><br/>');
      });
    }, "json");
  });

  $(document).on("click", "a", function(){
    var elem=$(this);
    //var data='barcode='+elem.attr('data-linkid');
    //alert('testing '+data);
    $.ajax({
      type: "POST",
      url: 'findUser.php',
      data: 'uid='+elem.attr('data-linkid'),
      dataType: 'json',
      success: function(data) {
        $('#editForm').html(
          'Firstname: <input type="text" name="first" value="'+data['first']+'" /><br/>Surname: <input type="text" name="surname" value="'+data['surname']+'" /><br/>Email: <input type="text" name="email" value="'+data['email']+'" /><br/> Access: <input type="text" name="acess" value="'+data['access']+'" /><input type="hidden" name="uid" value="'+data['uid']+'" />'
        );
        $('#editSubmit').css('visibility', 'visible');
        $('#editContent').hide();
        $('#editSearchDiv').hide();
      }
    });
  });

  $(document).ready(function(){
    $("a").trigger("click");
  });
})
</script>
<div class='container'>
  <form id='formShow'>
    <select id='formSelect'>
      <option value='' selected='selected'></option>
      <option value='add'>Add a User</option>
      <option value='edit'>Edit a User</option>
      <option value='delete'>Delete a User</option>
    </select>
  </form>

  <form id='add' name='add' action='updateUser.php' method='POST' style='display:none'>
    <label for='firstname'>Firstname</label> <input type='text' name='first' />
    <label for='surname'>Surname</label> <input type='text' name='surname' />
    <label for='emailAddress'>Email Address</label> <input type='text' name='email' />
    <label for='userName'>Username</label> <input type='text' name='user' />
    <label for='pass'>Password</label> <input type='password' name='password' />
    <label for='accessSelect'>Access Rights</label>
    <select name='access'>
      <option value=''></option>
      <option value='U'>User</option>
      <option value='C'>Contributor</option>
      <option value='A'>Admin</option>
    </select>
    <input type='hidden' name='type' value='add' />
    <input type='submit' value='Add User' class='btn btn-primary btn-sml' />
  </form>

  <form id='edit' name='edit' action='updateUser.php' method='POST' style='display:none'>
    <div id='editSearchDiv'>
      <label for='searchEdit'>Search for User</label><input type='text' id='editSearch' />
    </div>
    <div id='editContent'>
    </div>
    <div id='editForm'>
    </div>
    <input type='hidden' value='edit' name='type' />
    <input type='submit' id='editSubmit' value='Edit User' class='btn btn-primary btn-sml' />
  </form>

  <form id='delete' name='delete' action='updateUser.php' method='POST'>
  </form>
</div>
