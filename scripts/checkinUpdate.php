<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/connect.php";
include_once($path);
$loanNumber = $_POST['loanNumber'];
$lateNotes=$_POST['dateNotes'];
$damagedNotes=$_POST['damagedNotes'];
$damaged=$_POST['damaged'];
$endDate=$_POST['date'];

$notes .= $lateNotes;
$notes .= $damagedNotes;

$sql="UPDATE loan SET actualEnd='$endDate', notes='$notes', damaged='$damaged'
WHERE loanNumber='$loanNumber'";
$findAsset="SELECT barcode FROM loantoasset WHERE loanNumber='$loanNumber'";
$selectResult=mysqli_query($conn, $findAsset);
while($row=mysqli_fetch_row($selectResult)){
  $uid[]=$row[0];
}
foreach($uid as $id){
  $updateSQL = "UPDATE assets SET status='In Stock' WHERE id='$id'";
  mysqli_query($conn, $updateSQL);
}
if($result=mysqli_query($conn, $sql)){
  header('Location: /pendingCheckin.php?loanNumber='.$loanNumber.'&type=checkin');
}
else{
  echo "Error: ".$conn->error;
}

?>
