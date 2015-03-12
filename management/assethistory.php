<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$connectPath .= $path;
$connectPath .= "/connect.php";
$headerPath .= $path;
$headerPath .= "/header.php";
include($connectPath);
include($headerPath);
$assetID=$_REQUEST['id'];
?>
<div class='container'>
  <h2>Asset History</h2>
  <?php
  $sql="SELECT *
  FROM assets INNER JOIN loantoasset
  ON loantoasset.barcode=assets.id
  INNER JOIN loan
  ON loan.loanNumber=loantoasset.loanNumber
  WHERE assets.id='$assetID'";
  ?>
</div>
<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= $path;
$footerPath .= "/footer.php";
include($footerPath);
?>
