<?php
session_start();
include('connect.php');
include('header.php');
$uid = $_SESSION['uid'];
$start='11-02-15';
$end='13-02-15';
$i=0;
$description = $_POST['reasons'];

$email_to='marcus-rowland@hotmail.co.uk';
$email_subject='Test loan';


$emailQuery="SELECT email, firstname, surname FROM user WHERE UID='$uid' LIMIT 1";
if($result=mysqli_query($conn, $emailQuery)){
  while($row=mysqli_fetch_row($result)){
    $email_from=$row[0];
    $first=$row[1];
    $surname=$row[2];
  }
}

foreach($_POST['make'] as $key=>$make){
  $barcode[$i]=$_POST['barcode'][$key];
  $make[$i]=$_POST['make'][$key];
  $model[$i]=$_POST['model'][$key];
  $stage_email .= "\nBarcode: ".$barcode[$i]."\n";
  $stage_email .= "Make: ".$make[$i]." Model: ".$model[$i]."\n";
  $i++;
}

$sqlLoan="INSERT INTO loan (count, plannedStart, plannedEnd, UID) VALUES ('$i', '$start', '$end', '$uid')";
mysqli_query($conn, $sqlLoan);
$loanNumber = mysqli_insert_id($conn);

$count=0;
while($count<=$i){
  $bcodeVal=$barcode[$count];
  $sql="INSERT INTO loantoasset (loanNumber, barcode) VALUES ('$loanNumber', '$bcodeVal')";
  mysqli_query($conn, $sqlLoan);
  $count++;
}

$email_message = "Please find the information below: ";
$email_message .= "Name: ".$first." ".$surname."\n";
$email_message .= $stage_email;
$email_message .= "From: ".$start." To: ".$end."\n";
$email_message .= $description;

$headers = "From: ".$email_from."\r\n".
"Reply-To: ".$email_from."\r\n".
"X-Mailer: PHP/".phpversion();
@mail($email_to, $email_subject, $email_message, $headers);

?>

<div class="container">
  Thank you for your loan request, you should be informed shortly
</div>
