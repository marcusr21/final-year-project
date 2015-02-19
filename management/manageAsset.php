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
})
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
  </form>
  <form id='edit' name='edit' method='POST' action='update.php' style='display:none'>
    Asset Number: <input type='text' id='editBarcode' />
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
