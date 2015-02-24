<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$connectPath .= $path;
$connectPath .= "/connect.php";
include($connectPath);

if(isset($_POST['type']) && $_POST['type']=='edit'){
  $barcode=$_POST['barcode'];
  $sql=
}
elseif(isset($_POST['type']) && $_POST['type']=='add'){
  //do add here
}
elseif(isset($_POST['type']) && $_POST['type']=='delete'){
  //do delete here
  //transfer to recently deleted table
}
?>
