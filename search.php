<?php
require_once('connect.php');
  $array=array();
    $key=$_POST['keywords'];
    $array = array();
    $sql="SELECT * FROM assets WHERE description like '%$key%'";
    $query=mysqli_query($conn, $sql);
      while($row=mysqli_fetch_array($query))
      {
        $array[] = array('id'=>$row['barcode'], 'make'=>$row['make'], 'model'=>$row['model']);
      }

    echo json_encode($array);
?>
