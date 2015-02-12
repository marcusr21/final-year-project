<?php
session_start();
include_once('connect.php');
include('header.php');
?>
<script>
/*$(document).ready(function(){
  var form = $(this);
  var buttonClass = $(".buttons");

  $(form).submit(function(event){
    event.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
      type: 'post',
      url: 'ajax-form.php',
      data: formData,
      dataType: 'json',
      success: function(json){
        buttonClass.removeClass('error');
        buttonClass.addClass('success');

        $(buttonClass).text(response);
      }
    })
  });
})*/
</script>
<div class="container">
  <h2>Pending Loans</h3>
    <p>Here you can manage any pending loans that are due to be approved or checked-out</p>
</div>
<?php
$i=0;

$selectQuery="SELECT loan.loanNumber, count, plannedStart, plannedEnd, user.UID, firstname, surname
FROM loan INNER JOIN user ON loan.UID=user.UID
WHERE actualStart IS NULL AND approved IS NULL";

if(isset($_GET['loanNumber']) && isset($_GET['type'])){
  echo "Loan number: ".$_GET['loanNumber']." ".$_GET['type']."<br/>\n";
}

if($results=mysqli_query($conn, $selectQuery)){
  while($row=mysqli_fetch_row($results)){
    //display normal results
    $loanNumber=$row[0];
    $count = $row[1];
    echo "Number of Requested Items: ".$count;
    echo "<form name='ajaxform' id='ajaxform' action='ajax-form.php' method='POST'>";
    echo "Planned Start: ".$row[2]." Planned End: ".$row[3]."<br/>\n";
    echo "Name: ".$row[5]." ".$row[6]."</br>\n";
    $sql="SELECT loantoasset.barcode, make, model
    FROM loantoasset INNER JOIN assets ON loantoasset.barcode = assets.barcode
    WHERE loanNumber='$loanNumber'";
    $result=mysqli_query($conn, $sql);
    if($count > 1){
        while($assetRow=mysqli_fetch_array($result)){
          $barcode=$assetRow[0];
          echo "Barcode: ".$barcode."</br>\n";
          echo "Make: ".$assetRow['make']." Model: ".$assetRow['model']."<br/>\n";
        }
    }
    else {
      while($singleassetRow=mysqli_fetch_array($result)){
      echo "Barcode: ".$singleassetRow[0]."</br>\n";
      echo "Make: ".$singleassetRow['make']." Model: ".$singleassetRow['model']."<br/>\n";
    }
      //mysqli_free_result($result);
    }
    echo "<input type='hidden' value='".$loanNumber."' name='loanNumber' />";
    echo "<div class='buttons'>";
    echo "<input type='submit' value='Approve' name='type' class='btn btn-success btn-sml' />";
    echo "<input type='submit' value='Reject' name='type' class='btn btn-danger btn-sml' />";
    echo "</div>";
    echo "</form><br/>\n";
    $i++;
  }
  //mysqli_free_result($results);
}
else {
  echo "Error: ".$selectQuery." ".$conn->error;
}
?>
</div>
