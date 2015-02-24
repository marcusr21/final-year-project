<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$connectPath .= $path;
$connectPath .= "/connect.php";
include($connectPath);

$barcode=$_POST['barcode'];
$make=$_POST['make'];
$model=$_POST['model'];
$tags=$_POST['tags'];
$desc=$_POST['description'];
$cat=$_POST['category'];

if(isset($_POST['type']) && $_POST['type']=='edit'){
  $sql="UPDATE assets
  SET barcode='$barcode', make='$make', model='$model', tags='$tags', description='$desc', category='$cat'
  WHERE barcode='$barcode'";
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
  $sql="INSERT INTO assets
  "
}
elseif(isset($_POST['type']) && $_POST['type']=='delete'){
  $sql="DELETE FROM assets
  WHERE barcode='$barcode'";
  if(mysqli_query($conn, $sql) === TRUE){
    header('Location: manageAsset.php?type=deleted&id='.$barcode);
  }
  else{
    echo "Error ".$conn->error;
  }
  //transfer to recently deleted table
}
?>
