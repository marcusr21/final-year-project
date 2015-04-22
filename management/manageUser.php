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
  if($_REQUEST['type']=='email'){
    echo "Error, email already exists";
  }
  else{
    echo "User has been ".$_REQUEST['type'];
  }
}
?>
<script>
$(document).ready(function(){

  $('#addUser').click(function() {
    $('#add').show();
    $('#edit').hide();
    $('#delete').hide();
  });

  $('#editUser').click(function(){
    $('#edit').show();
    $('#editSearchDiv').show();
    $('#delete').hide();
    $('#add').hide();
  });

  $('#deleteUser').click(function(){
    $('#delete').show();
    $('#deleteSearchDiv').show();
    $('#add').hide();
    $('#edit').hide();
  });

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

  $('#deleteSearch').on('input', function(){
    $('#deleteContent').show();
    var searchKeyword= $(this).val();
    $.post('searchUser.php', {keywords: searchKeyword}, function(data) {
      $('#deleteContent').empty();
      $.each(data, function(){
        $('#deleteContent').append('<a href="#" class="link" data-linkid="'+this.uid+'">'+this.firstname+' '+this.surname+'</a><br/>');
      });
    }, "json");
  });

  $(document).on("click", ".link", function(){
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
          'Firstname: <input type="text" id="first" name="first" value="'+data['first']+'" /><br/>Surname: <input type="text" id="surname" name="surname" value="'+data['surname']+'" /><br/>Email: <input type="text" id="email" name="email" value="'+data['email']+'" /><br/> Access: <input type="text" name="acess" value="'+data['access']+'" /><input type="hidden" name="uid" value="'+data['uid']+'" />'
        );
        $('#editSubmit').css('visibility', 'visible');
        $('#editContent').hide();
        $('#editSearchDiv').hide();
      }
    });
  });

  $(document).on("click", ".link", function(){
    var elem=$(this);
    //var data='barcode='+elem.attr('data-linkid');
    //alert('testing '+data);
    $.ajax({
      type: "POST",
      url: 'findUser.php',
      data: 'uid='+elem.attr('data-linkid'),
      dataType: 'json',
      success: function(data) {
        $('#deleteForm').html(
          'Firstname: <input type="text" name="first" value="'+data['first']+'" /><br/>Surname: <input type="text" name="surname" value="'+data['surname']+'" /><br/>Email: <input type="text" name="email" value="'+data['email']+'" /><br/> Access: <input type="text" name="acess" value="'+data['access']+'" /><input type="hidden" name="uid" value="'+data['uid']+'" />'
        );
        $('#deleteModal').css('visibility', 'visible');
        $('#deleteContent').hide();
        $('#deleteSearchDiv').hide();
      }
    });
  });

  $('#deleteModal').click(function(){
    $('#deleteConfirm').show();
    $('#deleteSubmit').show();
    $('#deleteClose').show();
  })

  $('#email').on('input', function() {
    var input=$(this);
    var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    var is_email=re.test(input.val());
    if(is_email){input.removeClass("invalid").addClass("valid");}
    else{input.removeClass("valid").addClass("invalid");}
  });

  $('#addButton').click(function(e){
    if($('#email').hasClass("invalid")){
      alert('Please complete all registration fields');
      e.preventDefault(e);
    }
    if($.trim($('#first').val()) == ''){
      alert('Please complete all registration fields');
      e.preventDefault(e);
    }
    if($.trim($('#surname').val()) == ''){
      alert('Please complete all registration fields');
      e.preventDefault(e);
    }
    if($.trim($('#user').val()) == ''){
      alert('Please complete all registration fields');
      e.preventDefault(e);
    }
    if($.trim($('#password').val()) == ''){
      alert('Please complete all registration fields');
      e.preventDefault(e);
    }
    if($('#access').val()==''){
      alert('Please complete all registration fields');
      e.preventDefault(e);
    }
  });

  /*$(document).ready(function(){
    $("a").trigger("click");
  });*/
})
</script>
<div class='container'>
  <div class='option'>
    <h3><a href='#' id='addUser'>Add User</a></h3>
  </div>
  <div class='option'>
    <h3><a href='#' id='editUser'>Edit User</a></h3>
  </div>
  <div class='option'>
    <h3><a href='#' id='deleteUser'>Delete User</a></h3>
  </div>

  <form id='add' name='add' action='updateUser.php' method='POST' style='display:none'>
    <label for='firstname'>Firstname</label> <input type='text' id="first" name='first' /><br/>
    <label for='surname'>Surname</label> <input type='text' id="surname" name='surname' /><br/>
    <label for='emailAddress'>Email Address</label> <input type='text' id="email" name='email' /><br/>
    <label for='userName'>Username</label> <input type='text' id="user" name='user' /><br/>
    <label for='pass'>Password</label> <input type='password' id="password" name='password' /><br/>
    <label for='accessSelect'>Access Rights</label>
    <select name='access' id="access">
      <option value=''></option>
      <option value='U'>User</option>
      <option value='C'>Contributor</option>
      <option value='A'>Admin</option>
    </select>
    <input type='hidden' name='type' value='add' />
    <input type='submit' id="addButton" value='Add User' class='btn btn-primary btn-sml' /><br/>
  </form>

  <form id='edit' name='edit' action='updateUser.php' method='POST' style='display:none'>
    <div id='editSearchDiv' style='display:none'>
      <label for='searchEdit'>Search for User</label><input type='text' id='editSearch' />
    </div>
    <div id='editContent'>
    </div>
    <div id='editForm'>
    </div>
    <input type='hidden' value='edit' name='type' />
    <input type='submit' id='editSubmit' value='Edit User' style='visibility:hidden' class='btn btn-primary btn-sml' />
  </form>

  <form id='delete' name='delete' action='updateUser.php' method='POST'>
    <div id='deleteSearchDiv' style='display:none'>
      <label for='searchDelete'>Search for User</label><input type='text' id='deleteSearch' />
    </div>
    <div id='deleteContent'>
    </div>
    <div id='deleteForm'>
    </div>
    <input type='hidden' value='delete' name='type' />
    <button type='button' id='deleteModal' style='visibility:hidden' data-toggle='modal' data-target='#deleteConfirm' class='btn btn-danger btn-sml'>Delete User</button>
    <div class='modal fade' id='deleteConfirm' tabindex='-1' role='dialog' aria-labelledby="myModalLabel" aria-hidden="true">
      <div class='modal-dialog'>
        <div class='modal-content'>
          <h4 class='modal-title'>Confirm Delete</h4>
        <div class='modal-body'>
          <p>Are you sure that you would like to delete this user?</p>
          <p>This user will lose their access immediately</p>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-default' id='deleteClose' data-dismiss='modal' style='display:none'>Close</button>
          <input type='submit' value='Delete User' id='deleteSubmit' class='btn btn-danger' style='display:none' />
        </div>
      </div>
    </div>
  </div>
  </form>
</div>
