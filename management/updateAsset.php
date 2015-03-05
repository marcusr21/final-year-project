<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$connectPath .= $path;
$connectPath .= "/connect.php";
include($connectPath);
date_default_timezone_set('UTC');

$barcode=$_POST['barcode'];
$make=$_POST['make'];
$model=$_POST['model'];
$tags=$_POST['tags'];
$desc=$_POST['description'];
$cat=$_POST['category'];
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
    //$array=array('result'=>'Update Failed');
    echo "Error ".$conn->error;
  }
  //echo json_encode($array);
}
elseif(isset($_POST['type']) && $_POST['type']=='add'){
  $sql="INSERT INTO assets (id, make, model, description, category, status, createdate, tags)
  VALUES ($barcode, '$make', '$model', '$desc', '$categoryid', 'In Stock', '$today', '$tags')";
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
