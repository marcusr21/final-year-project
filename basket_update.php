<?
session_start();
require_once('connect.php');

if(isset($_GET["barcode"])){
  $barcode = $_GET["barcode"];
  $start = $_GET["start"];
  $end = $_GET["end"];

  $query = "SELECT make, model FROM assets where barcode = '$barcode' LIMIT 1";
  if($result=mysqli_query($conn, $query)) {
    while($row=mysqli_fetch_row($result))
    {
      
    }
  }
}
?>
