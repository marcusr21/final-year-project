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
  $('#addAsset').click(function() {
    $('#add').show();
    $('#edit').hide();
    $('#delete').hide();
    $('#allAssetContainer').hide();
  });

  $('#editAsset').click(function(){
    $('#edit').show();
    $('#editSearchDiv').show();
    $('#delete').hide();
    $('#add').hide();
    $('#allAssetContainer').hide();
  });

  $('#deleteAsset').click(function(){
    $('#delete').show();
    $('#deleteSearchDiv').show();
    $('#add').hide();
    $('#edit').hide();
    $('#allAssetContainer').hide();
  });

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

  $(document).on("click", ".link", function(){
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
        $('#deleteModal').css('visibility', 'visible');
        $('#deleteContent').hide();
        $('.searchBox').hide();
        $('#allAssetContainer').hide();
      }
    });
  });


    $(document).on("click", ".link", function(){
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
          $('#allAssetContainer').hide();
        }
      });
    });

    $('#editButton').click(function(){
      var elem=$(this);
      $.ajax({
        type: "POST",
        url: "findAsset.php",
        data: "barcode="+elem.attr('value'),
        dataType: "json",
        success: function(data) {
          $('.editForm').html(
            'Make <input type="text" id="make" name="make" value="'+data["make"]+'"><br/>Model: <input type="text" name="model" id="model" value="'+data["model"]+'"><br/> Description: <input type="textarea" name="desc" value="'+data["description"]+'"><br/>Tags: <input type="text" id="tags" name="tags" value="'+data["tags"]+'"><br/> Category: <input type="text" id="category" name="category" value="'+data["category"]+'"><input type="hidden" id="barcode" name="barcode" value="'+data["barcode"]+'">'
          );
          $('#editSubmit').css('visibility', 'visible');
          $('#content').hide();
          $('.searchBox').hide();
          $('#allAssetContainer').hide();
          $('#edit').show();
        }
      });
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

    $('#deleteModal').click(function(){
      $('#deleteConfirm').show();
      $('#deleteSubmit').show();
      $('#deleteClose').show();
    })

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
  <div class='option'>
    <h3><a href='#' id='addAsset'>Add Asset</a></h3>
  </div>
  <div class='option'>
    <h3><a href='#' id='editAsset'>Edit Asset</a></h3>
  </div>
  <div class='option'>
    <h3><a href='#' id='deleteAsset'>Delete Asset</a></h3>
  </div>

  <div id='allAssetContainer'>
    <?php
    $sqlQuery="SELECT * FROM assets ORDER BY id";
    if($results=mysqli_query($conn, $sqlQuery)){
      while($row=mysqli_fetch_array($results)){
        echo "Asset Number: <label for='barcode' id='labelBarcode'>".$row['id']."</label>\n<br/>";
        echo "Make: ".$row['make']." ".$row['model']."<br/>\n";
        echo "<button type='button' id='editButton' value='".$row['id']."' class='btn btn-primary btn-sml'>Edit Asset</button>\n";
        echo "<button type='button' id='deleteButton' value='".$row['id']."' class='btn btn-danger btn-sml'> Delete Asset</button><br/>\n";
      }
    }
    ?>
  </div>
  <form id='add' name='add' method='POST' action='updateAsset.php' style='display:none'>
    Asset Number: <input type='text' id='barcode' name='barcode' /><br/>
    Make: <input type='text' id='make' name='make' /><br/>
    Model: <input type='text' id='model' name='model' /><br/>
    Description: <textarea rows='2' cols='40' name='description' id='description'></textarea><br/>
    Tags: <input type='text' id='tags' name='tags' /><br/>
    Category: <select id='cat' name='cat'><br/>
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
    <input type='hidden' value='add' id='type' name='type' /><br/>
    <input type='submit' value='Add Asset' class='btn btn-primary btn-sml' /><br/>
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
    <button id='deleteSearchAgain'>Search Again</button>
    <div id='deleteSearchBox'>
      Search for Asset: <input type='text' id='deleteSearch' />
    </div>
    <div id='deleteContent'>
    </div>
    <div id='deleteForm'>
    </div>
    <input type='hidden' id='type' name='type' value='delete' /?>
    <button type='button' class='btn btn-danger btn-sml' data-toggle='modal' data-target='#deleteConfirm' id='deleteModal' style='visibility:hidden'>Delete Asset</button>
    <div class='modal fade' id='deleteConfirm' tabindex='-1' role='dialog' aria-labelledby="myModalLabel" aria-hidden="true">
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header'>
          <h4 class='modal-title'>Confirm Delete</h4>
        </div>
        <div class='modal-body'>
          <p>Are you sure that you would like to delete this asset?</p>
          <p>This asset will not exist in the records</p>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-default' id='deleteClose' data-dismiss='modal' style='display:none'>Close</button>
          <input type='submit' value='Delete Asset' id='deleteSubmit' class='btn btn-danger' style='display:none' />
        </div>
      </div>
    </div>
  </div>
  </form>
</div>
<?php
$footerPath .= $path;
$footerPath .= "/footer.php";
include($footerPath);
?>
