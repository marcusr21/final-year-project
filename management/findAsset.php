<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$connectPath .= $path;
$connectPath .= "/connect.php";
include($connectPath);

$array=array();
if(isset($_POST['barcode'])){
  $id=$_POST['barcode'];
  $sql="SELECT * FROM assets where barcode='$id'";
  $query=mysqli_query($conn, $sql);
  while($row=mysqli_fetch_array($query)){
    $array=array('make'=>$row['make'], 'model'=>$row['model'], 'description'=>$row['description'], 'tags'=>$row['tags'], 'category'=>$row['category']);
  }
  echo json_encode($array);
}
?>
