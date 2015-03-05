<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$connectPath .= $path;
$connectPath .= "/connect.php";
include($connectPath);

$array=array();

$key = $_POST['keywords'];

$sql="SELECT uid, firstname, surname
FROM user WHERE MATCH (firstname, surname) AGAINST ('$key*' IN BOOLEAN MODE)";
$query=mysqli_query($conn, $sql);
while($row=mysqli_fetch_array($query)){
  $array[]=array('uid'=>$row['uid'], 'firstname'=>$row['firstname'], 'surname'=>$row['surname']);
}

echo json_encode($array);
?>
