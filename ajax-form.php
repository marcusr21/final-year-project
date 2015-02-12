<?php
session_start();
include('connect.php');
$uid = $_SESSION['uid'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $loanNumber = $_POST['loanNumber'];
  if(isset($_POST['type']) && $_POST['type'] == 'Approve'){
    $sql = "UPDATE loan SET approved='Y', approver='$uid' WHERE loanNumber='$loanNumber'";
    if($conn->query($sql)){
        //$response=array('approve'=>"Loan approved");
        header("Location: pendingLoans.php?loanNumber=".$loanNumber."&type=approved");
    }
    else{
      $response = "An error has occured";
      exit;
    }
  }
  if(isset($_POST['type']) && $_POST['type'] == 'Reject'){
    $sql="UPDATE loan SET approved='N', approver='$uid'
    WHERE loanNumber='$loanNumber'";
    if($result=mysqli_query($conn, $sql)){
      //$response= array("reject"=>"Loan rejected");
      header("Location: pendingLoans.php?loanNumber=".$loanNumber."&type=rejected");
    }
    else{
      $response = array('reject'=>"An error has occured");
      header("Content-Type: application/json");
      echo json_encode($response);
    }
  }
}
?>
