<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$connectPath .= $path;
$connectPath .= "/connect.php";
include($connectPath);
date_default_timezone_set('UTC');

$barcode=mysqli_real_escape_string($_POST['barcode']);
$make=mysqli_real_escape_string($_POST['make']);
$model=mysqli_real_escape_string($_POST['model']);
$tags=mysqli_real_escape_string($_POST['tags']);
$desc=mysqli_real_escape_string($_POST['description']);
$cat=mysqli_real_escape_string($_POST['category']);
$categoryid=$_POST['cat'];
$today=date('Y-m-d');

//print_r($_POST['type']);

if(isset($_POST['type']) && $_POST['type']=='edit'){
  $sql="UPDATE assets
  SET id='$barcode', make='$make', model='$model', tags='$tags', description='$desc', category='$cat'
  WHERE id='$barcode'";
  if(mysqli_query($conn, $sql) === TRUE){
    //$array=array('result'=>'Asset updated');
    header('Location: manageAsset.php?type=edited&id='.$barcode);
  }
  else{
    echo "Error ".$conn->error;
  }
}
elseif(isset($_POST['type']) && $_POST['type']=='add'){
  $sql="INSERT INTO assets (id, make, model, description, category, status, createdate, tags, hardcase)
  VALUES ('$barcode', '$make', '$model', '$desc', '$categoryid', 'In Stock', '$today', '$tags', 'N')";
  if(mysqli_query($conn, $sql)===TRUE){
    header('Location: manageAsset.php?type=added&id='.$barcode);
  }
  else{
    echo "Error: ".$conn->error;
  }
}
elseif(isset($_POST['type']) && $_POST['type']=='delete'){
  $sql="DELETE FROM assets
  WHERE id='$barcode'";
  if(mysqli_query($conn, $sql) === TRUE){
    header('Location: manageAsset.php?type=deleted&id='.$barcode);
  }
  else{
    echo "Error ".$conn->error;
  }
  //transfer to recently deleted table
}
?>
