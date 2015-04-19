<?php
session_start();
include('header.php');
include('connect.php');

?>
<div class="container">
  <h2>Pending Check-in</h2>
  <p>Below is a list of all items that are due to be checked-in</p>
  <?php
  $sql="SELECT loanNumber, actualStart, plannedEnd, count, firstname, surname
  FROM loan INNER JOIN user
  ON loan.uid=user.uid
  WHERE actualStart IS NOT NULL and actualEnd IS NULL";
  if($result=mysqli_query($conn,$sql)){
  while($row=mysqli_fetch_array($result)){
    echo "<form action='checkin.php' method='POST'>\n";
    echo "Loan Number: ".$row['loanNumber']."<br/>\n";
    echo "User: ".$row['firstname']." ".$row['surname']."<br/>\n";
    echo "Start of Loan: ".$row['actualStart']."<br/>\n";
    echo "Planned finish: ".$row['plannedEnd']."<br/>\n";
    echo "Number of assets: ".$row['count']."<br/>\n";
    echo "<input type='hidden' value='".$row['loanNumber']."' name='loanNumber' />\n";
    echo "<input type='hidden' value='".$row['plannedEnd']."' name='plannedEnd' />\n";
    echo "<input type='submit' value='Check-in' class='btn btn-primary btn-sml' />\n";
    echo "</form>\n";
  }
}
else{
  echo "Error: ".$conn->error;
}
  ?>
</div>
<?php
include('footer.php');
?>
