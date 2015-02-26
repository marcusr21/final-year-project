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
    $('#content').show();
    var searchKeyword= $(this).val();
    $.post('/../search.php', {keywords: searchKeyword}, function(data) {
      $('#content').empty();
      $.each(data, function(){
        $('#content').append('<a href="#" class="link" data-linkid="'+this.id+'">'+this.make+' '+this.model+'</a><br/>');
      });
    }, "json");
  });

  $('#deleteSearch').on('input', function(){
    $('#deleteContent').show();
    var searchKeyword= $(this).val();
    $.post('/../search.php', {keywords: searchKeyword}, function(data) {
      $('#deleteContent').empty();
      $.each(data, function(){
        $('#deleteContent').append('<a href="#" class="link" data-linkid="'+this.id+'">'+this.make+' '+this.model+'</a><br/>');
      });
    }, "json");
  });

  $(document).on("click", "a", function(){
    var elem=$(this);
    var data='barcode='+elem.attr('data-linkid');
    //alert('testing '+data);
    $.ajax({
      type: "POST",
      url: 'findAsset.php',
      data: 'barcode='+elem.attr('data-linkid'),
      dataType: 'json',
      success: function(data) {
        $('#deleteForm').html(
          'Make <input type="text" id="make" name="make" value="'+data["make"]+'"><br/>Model: <input type="text" name="model" id="model" value="'+data["model"]+'"><br/> Description: <input type="textarea" name="desc" value="'+data["description"]+'"><br/>Tags: <input type="text" id="tags" name="tags" value="'+data["tags"]+'"><br/> Category: <input type="text" id="category" name="category" value="'+data["category"]+'"><input type="hidden" id="barcode" name="barcode" value="'+data["barcode"]+'">'
        );
        $('#deleteSubmit').css('visibility', 'visible');
        $('#deleteContent').hide();
        $('.searchBox').hide();
      }
    });
  });


    $(document).on("click", "a", function(){
      var elem=$(this);
      var data='barcode='+elem.attr('data-linkid');
      //alert('testing '+data);
      $.ajax({
        type: "POST",
        url: 'findAsset.php',
        data: 'barcode='+elem.attr('data-linkid'),
        dataType: 'json',
        success: function(data) {
          $('.editForm').html(
            'Make <input type="text" id="make" name="make" value="'+data["make"]+'"><br/>Model: <input type="text" name="model" id="model" value="'+data["model"]+'"><br/> Description: <input type="textarea" name="desc" value="'+data["description"]+'"><br/>Tags: <input type="text" id="tags" name="tags" value="'+data["tags"]+'"><br/> Category: <input type="text" id="category" name="category" value="'+data["category"]+'"><input type="hidden" id="barcode" name="barcode" value="'+data["barcode"]+'">'
          );
          $('#editSubmit').css('visibility', 'visible');
          $('#content').hide();
          $('.searchBox').hide();
        }
      });
    });

    $(document).ready(function(){
      $("a").trigger("click");
    });

    $('#editSearchAgain').click(function(event){
      event.preventDefault();
      event.unbind();
      $('.editSearchBox').show();
      $('.editForm').hide();
      $('#editSubmit').css('visibility', 'hidden');
    });

    $('#deleteSearchAgain').click(function(event){
      event.preventDefault();
      event.unbind();
      $('.deleteSearchBox').show();
      $('.deleteForm').hide();
      $('#deleteSubmit').css('visibility', 'hidden');
    });

    /*$('#edit').submit(function(event){

      var postData=$(this).serializeArray();
      var formURL=$(this).attr('action');
      $.ajax({
        url: formURL,
        type: 'POST',
        data: postData,
        success: function(data){
          $('.editForm').hide();
          $('#editSubmit').css('visibility', 'hidden');
          $('#content').html('<p>'+data['result']+'</p>');
        }
      })
      event.preventDefault();
      event.unbind();
    });*/
});
</script>
<div class='container'>
  <form id='formShow'>
    <select id='formSelect'>
      <option value='' selected='selected'></option>
      <option value='add'>Add an asset</option>
      <option value='edit'>Edit an asset</option>
      <option value='delete'>Delete an asset</option>
    </select>
  </form>

  <form id='add' name='add' method='POST' action='updateAsset.php' style='display:none'>
    Asset Number: <input type='text' id='barcode' name='barcode' />
    Make: <input type='text' id='make' name='make' />
    Model: <input type='text' id='model' name='model' />
    Description: <textarea rows='2' cols='40' name='description' id='description'></textarea>
    Tags: <input type='text' id='tags' name='tags' />
    Category: <select id='cat' name='cat'>
      <option value='' selected='selected'></option>
      <?php
      $sql="SELECT * FROM category";
      $results=mysqli_query($conn,$sql);
      while($row=mysqli_fetch_array($results)){
        echo "<option value='".$row['id']."'>".$row['category']."</option>\n";
      }
      mysqli_free_result($results);
      ?>
    </select>
    <input type='hidden' value='add' id='type' name='type' />
    <input type='submit' value='Add Asset' class='btn btn-primary btn-sml' />
  </form>

  <form id='edit' name='edit' method='POST' action='updateAsset.php' style='display:none'>
    <button id='editSearchAgain'>Search Again</button>
    <div id='editSearchBox'>
      Search for Asset: <input type='text' id='editSearch' />
    </div>
    <div id='content'>
    </div>
    <div class='editForm'>
    </div>
    <input type='hidden' id='type' name='type' value='edit' />
    <input type='submit' class='btn btn-primary btn-sml' id='editSubmit' value='Edit Asset' style='visibility:hidden' />
  </form>

  <form id='delete' name='delete' method='POST' action='updateAsset.php' style='display:none'>
    <button id='deleteSearchAgain'>Search Aagin</button>
    <div id='deleteSearchBox'>
      Search for Asset: <input type='text' id='deleteSearch' />
    </div>
    <div id='deleteContent'>
    </div>
    <div id='deleteForm'>
    </div>
    <input type='hidden' id='type' name='type' value='delete' /?>
    <input type='submit' class='btn btn-primary btn-sml' id='deleteSubmit' value='Delete Asset' style='visibility:hidden' />
  </form>
</div>
<?php
$footerPath .= $path;
$footerPath .= "/footer.php";
include($footerPath);
?>