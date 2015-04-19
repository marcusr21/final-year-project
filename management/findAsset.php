<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$connectPath .= $path;
$connectPath .= "/connect.php";
include($connectPath);

$array=array();
if(isset($_POST['barcode'])){
  $id=$_POST['barcode'];
  $sql="SELECT assets.id, make, model, description, tags, category.category
  FROM assets
  INNER JOIN category
  ON assets.category=category.id
  WHERE assets.id='$id'";
  $query=mysqli_query($conn, $sql);
  while($row=mysqli_fetch_array($query)){
    $category=$row[5];
    $array=array('barcode'=>$id, 'make'=>$row['make'], 'model'=>$row['model'], 'description'=>$row['description'], 'tags'=>$row['tags'], 'category'=>$row[5]);
  }
  echo json_encode($array);
}
?>
