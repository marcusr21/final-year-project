<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/connect.php";
include_once($path);
$loanNumber=$_POST['loanNumber'];
$startDate=$_POST['date'];
$dateReasons = isset($_POST['dateNotes']);
$otherNotes=isset($_POST['notes']);

$notes .= $dateReasons;
$notes .= $otherNotes;

$sql="UPDATE loan SET actualStart='$startDate', notes='$notes'
WHERE loanNumber='$loanNumber'";
if($result=mysqli_query($conn, $sql)){
  header('Location: /pendingLoans?loanNumber='.$loanNumber.'&type=checkout');
}
else{
  echo "Error: ".$conn->error;
}
?>
