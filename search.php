<?php
require_once('connect.php');
    $array=array();
    $key=$_POST['keywords'];
    $sql="SELECT * FROM assets
    WHERE MATCH (make, model, description, tags) AGAINST ('*$key*' IN BOOLEAN MODE)";
    $query=mysqli_query($conn, $sql);
      while($row=mysqli_fetch_array($query))
      {
        $array[] = array('id'=>$row['id'], 'make'=>$row['make'], 'model'=>$row['model']);
      }

    echo json_encode($array);
?>
