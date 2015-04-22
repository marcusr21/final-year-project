<?php
include('connect.php');
$email=$_POST['email'];
$email_from=$_POST['email'];
$id=$_POST['id'];

function randomPassword(){
  $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
  $pass = array(); //declare new password as array
  $alphaLength = strlen($alphabet) - 1;
  for ($i = 0; $i < 8; $i++) {
      $n = rand(0, $alphaLength); //find random character from alphabet
      $pass[] = $alphabet[$n]; //use this random character to compelte string
  }
  return implode($pass); //turn the array into a string
}

if($id=="username"){ //if user wants username retrieving use this
  $sql="SELECT username FROM user WHERE email='$email' LIMIT 1";
  if($result=mysqli_query($conn, $sql)){
    $number=mysqli_num_rows($result);
    if($number==0){
      echo "There are no records for your email address";
    }
    else{
      while($row=mysqli_fetch_array($result)){
        $username=$row['username'];
      }
    }
  }
  $email_subject="Username Reminder";
  $email_to=$email;
  $email_message="Dear user, \n";
  $email_message.="You have requested a username reminder, please find it below.\n";
  $email_message.="Username: ".$username; //craft email body

  $headers = "From: ".$email_from."\r\n".
  "Reply-To: ".$email_from."\r\n".
  "X-Mailer: PHP/".phpversion();
  mail($email_to, $email_subject, $email_message, $headers);

  echo "Message sent successfully, please check your emails"; //send the email to the user
}

if($id=="password"){ //if password reset required
  $sql="SELECT username FROM user WHERE email='$email' LIMIT 1";
  if($result=mysqli_query($conn, $sql)){
    $number=mysqli_num_rows($result);
    if($number==0){
      echo "There are no records for your email address";
      return;
    }
    else{
      while($row=mysqli_fetch_array($result)){
        $username=$row['username'];
      }
    }
  }

  $password=randomPassword(); //use random password function
  $hash=password_hash($password, PASSWORD_BCRYPT); //hash the random password
  $token=randomPassword(); //use random password function to create token

  $sql="UPDATE user SET password='$hash', token='$token' WHERE email='$email'";
  $result=mysqli_query($conn, $sql); //update database to set the new password and token

  $email_subject="Password Reset";
  $email_to=$email;
  $email_message="<html>Dear User, \n"; //craft html email
  $email_message.="You have requested a password reset, which you can find below. If this was not you then please make note of the password below and contact the admin immediately \n";
  $email_message.="New password: ".$password."\n";
  $email_message.="Please follow this link to reset your password. <a href='localhost/passwordreset.php?token=".$token."'>Reset here</a></html>";

  $headers = "From: ".$email_from."\r\n".
  "Reply-To: ".$email_from."\r\n".
  "MIME-Version: 1.0" . "\r\n".
  "Content-type:text/html;charset=UTF-8" . "\r\n".
  "X-Mailer: PHP/".phpversion();
  mail($email_to, $email_subject, $email_message, $headers); //send email

  echo "Password reset successfully, please check your emails";
}
?>
