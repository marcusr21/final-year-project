<?php
session_start();
include('connect.php');
$uid = $_SESSION['uid'];
$email_from = "marcus-rowland@hotmail.co.uk";


if($_SERVER["REQUEST_METHOD"] == "POST"){
  $loanNumber = $_POST['loanNumber'];
  if(isset($_POST['type']) && $_POST['type'] == 'Approve'){
    $sql = "UPDATE loan SET approved='Y', approver='$uid' WHERE loanNumber='$loanNumber'";
    //update loan to approved
    if($conn->query($sql)){
      $i=0;
      $allUser="SELECT email FROM user WHERE access='C'";
      $result=mysqli_query($conn, $allUser);
      while($row=mysqli_fetch_array($result)){
        $email_to[$i]=$row['email'];
        $i++;
        //obtain all contributor emails to send the confirmation email
      }
      foreach($email_to as $to){
        $email_subject = "Loan approved";
        $email_message = "Loan number: ".$loanNumber." has now been approved";
        $headers = "From: ".$email_from."\r\n".
        "Reply-To: ".$email_from."\r\n".
        "X-Mailer: PHP/".phpversion();
        //craft email with headers
        mail($to, $email_subject, $email_message, $headers);
        //execute email send
      }
      header("Location: pendingLoans.php?loanNumber=".$loanNumber."&type=approved");
      //redirect and inform admin that loan has been approved
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
