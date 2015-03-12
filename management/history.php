<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$connectPath .= $path;
$connectPath .= "/connect.php";
$headerPath .= $path;
$headerPath .= "/header.php";
include($connectPath);
include($headerPath);
?>
<div class='container'>
  <h2>History of Items</h2>
  <p>Below you can click on an asset to view it's history</p>
  <?php
    $sql="SELECT * FROM assets";
    $result=mysqli_query($conn, $sql);
    while($row=mysqli_fetch_array($result)){
      echo "<div class='asset'>";
      echo "ID: ".$row['id']."<br/>\n";
      echo "Make: ".$row['make']." Model: ".$row['model']."<br/>\n";
      echo "<a href='assethistory.php?id=".$row['id']."'><button type='button' class='btn btn-default btn-sml'>View History</button></a>\n";
      echo "</div>";
    }
  ?>
</div>
<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$footerPath .= $path;
$footerPath .= "/footer.php";
include($footerPath);
?>
