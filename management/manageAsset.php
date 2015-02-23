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
?>
<script>
$(document).ready(function(){
  $("#formSelect").on("change", function() {
      $("#" + $(this).val()).show().siblings().hide();
  })

  $('#editBarcode').on('input', function(){
    var searchKeyword= $(this).val();
    $.post('/../search.php', {keywords: searchKeyword}, function(data) {
      $('#content').empty();
      $.each(data, function(){
        $('#content').append('<a href="#" class="link" data-linkid="'+this.id+'">'+this.make+' '+this.model+'</a><br/>');
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
          $('.editForm').html(
            'Make <input type="text" id="editModel" value="'+data["make"]+'"><br/>Model: <input type="text" id="editModel" value="'+data["model"]+'"><br/> Description: <input type="textarea" value="'+data["description"]+'"><br/>Tags: <input type="text" id="editTags" value="'+data["tags"]+'"><br/> Category: <input type="text" id="editCategory" value="'+data["category"]+'">'
          );
          console.log(data);
        }
      });
    });

    $(document).ready(function(){
      $("a").trigger("click");
    });
});
</script>
<div class='container'>
  <form id='form-show'>
    <select id='formSelect'>
      <option value='' selected='selected'></option>
      <option value='add'>Add an asset</option>
      <option value='edit'>Edit an asset</option>
      <option value='delete'>Delete an asset</option>
    </select>
  </form>

  <form id='add' name='add' method='POST' action='update.php' style='display:none'>
    Asset Number: <input type='text' id='addBarcode' />
    Make: <input type='text' id='addMake' />
    Model: <input type='text' id='addModel' />
    Description: <input type='textarea' />
    Tags: <input type='text' id='tags' />
    Category: <select id='category'>
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

  </form>
  <form id='edit' name='edit' method='POST' action='update.php' style='display:none'>
    Asset Number: <input type='text' id='editBarcode' />
    <div id='content'>
    </div>
    <div class='editForm'>
    </div>
    <!-- AJAX to lokup asset to be edited-->
  </form>
  <form id='delete' name='delete' method='POST' action='update.php' style='display:none'>
    Asset Number: <input type='text' id='deleteBarcode' />
    <!-- AJAX to lookup asset to be deleted-->
  </form>
</div>
<?php
$footerPath .= $path;
$footerPath .= "/footer.php";
include($footerPath);
?>
