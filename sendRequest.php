<?php
session_start();
include('connect.php');
include('header.php');
$uid = $_SESSION['uid'];
$start=$_POST['start'];
$end=$_POST['end'];
$i=0;
$description = $_POST['reasons'];
$test_to="marcus-rowland@hotmail.co.uk";

$email_subject='Loan Request';

$allUser="SELECT email FROM user WHERE access='A'";
$result=mysqli_query($conn, $allUser);
while($row=mysqli_fetch_array($result)){
  $email_to[$i]=$row['email'];
  $i++;
  //obtain all admin emails to send the request email
}


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
  //find all information of the assets to be loaned for email
}

$sqlLoan="INSERT INTO loan (count, plannedStart, plannedEnd, UID) VALUES ('$i', '$start', '$end', '$uid')";
//insert the basic loan details into the database
if($result=mysqli_query($conn, $sqlLoan)){
  $loanNumber = mysqli_insert_id($conn);
}
else {
  echo "error: ".$sqlLoan."<br/>".$conn->error;
}

$count=0;
while($count<=$i){
  $bcodeVal=$barcode[$count];
  $sql="INSERT INTO loantoasset (loanNumber, barcode) VALUES ('$loanNumber', '$bcodeVal')";
  $conn->query($sql);
  $count++;
}

$email_message = "Please find the information below: ";
$email_message .= "Name: ".$first." ".$surname."\n";
$email_message .= $stage_email;
$email_message .= "From: ".$start." To: ".$end."\n";
$email_message .= $description;

foreach($email_to as $to){
  $headers = "From: ".$email_from."\r\n".
  "Reply-To: ".$email_from."\r\n".
  "X-Mailer: PHP/".phpversion();
  mail($to, $email_subject, $email_message, $headers);
}
?>

<div class="container">
  Thank you for your loan request, you should be informed shortly
</div>
