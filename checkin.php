<?php
session_start();
include('connect.php');
include('header.php');

$loanNumber=isset($_POST['loanNumber']) ? isset($_POST['loanNumber']) : null;
$plannedEnd=strtotime(isset($_POST['plannedEnd'])) ? isset($_POST['plannedEnd']) : null;

$todayDate=strtotime(date('Y-m-d'));
$actualDate=date('Y-m-d');

echo "<div class='container'>";
echo "<form action='scripts/checkinUpdate' method='POST'>";
if($todayDate < $plannedEnd){
  echo "<p>Please write the reasons for late return";
  echo "<textarea name='datenotes' maxlength='200' class='form-control'></textarea>";
}
$sql="SELECT assets.id, make, model
FROM loantoasset INNER JOIN assets
ON loantoasset.barcode=assets.id
WHERE loanNumber='$loanNumber'";
$result=mysqli_query($conn, $sql);
while($row=mysqli_fetch_array($result)){
  echo "ID: ".$row['id']."<br/>\n";
  echo "Make: ".$row['make']." Model: ".$row['model']."<br/>\n";
  echo "Asset Damaged? <select id='damaged".$row['id']."'>";
  echo "<option></option>";
  echo "<option value='yes'>Yes</option>";
  echo "<option value='no'>No</option>";
  echo "</select>";
  echo "<p>If asset is damaged, please fill in the box below</p>";
  echo "<textarea name='damaged".$row['id']."' class='form-control' maxlength='200'> </textarea>";
}
echo "<input type='hidden' name='loanNumber' value='".$loanNumber"' />";
echo "<input type='submit' class='btn btn-primary btn-sml' value='Check-in' />";
echo "</form>";
echo "</div>";
?>
