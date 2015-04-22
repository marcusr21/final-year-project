<?php
session_start();
include('connect.php');
include('header.php');

$loanNumber=$_POST['loanNumber'];
$plannedEnd=strtotime(isset($_POST['plannedEnd'])) ? isset($_POST['plannedEnd']) : null;
//convert planned check-in date

$todayDate=strtotime(date('Y-m-d'));
$actualDate=date('Y-m-d');
//Get todays date
echo "<div class='container'>\n";
echo "<form action='scripts/checkinUpdate.php' method='POST'>\n";
if($todayDate < $plannedEnd){
  echo "<p>Please write the reasons for late return\n";
  echo "<textarea name='datenotes' maxlength='200' class='form-control'></textarea>\n";
}
$sql="SELECT assets.id, make, model
FROM loantoasset INNER JOIN assets
ON loantoasset.barcode=assets.id
WHERE loanNumber='$loanNumber'";
$result=mysqli_query($conn, $sql);
while($row=mysqli_fetch_array($result)){
  echo "ID: ".$row['id']."<br/>\n";
  echo "Make: ".$row['make']." Model: ".$row['model']."<br/>\n";
}
echo "Asset Damaged? <select id='damaged'>\n";
echo "<option></option>\n";
echo "<option value='yes'>Yes</option>\n";
echo "<option value='no'>No</option>\n";
echo "</select>\n";
echo "<p>If asset is damaged, please fill in the box below</p>\n";
echo "<textarea name='damagedNotes' class='form-control' maxlength='200'> </textarea>\n";
echo "<input type='hidden' name='loanNumber' value='".$loanNumber."' />\n";
echo "<input type='hidden' name='date' value='".$actualDate."' />\n";
echo "<input type='submit' class='btn btn-primary btn-sml' value='Check-in' />\n";
echo "</form>\n";
echo "</div>\n";
?>
