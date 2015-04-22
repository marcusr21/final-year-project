<?php
include('connect.php');
    $array=array();
    $key=$_POST['keywords'];
    $sql="SELECT *
    FROM assets
    WHERE MATCH (make, model, description, tags) AGAINST ('*$key*' IN BOOLEAN MODE)
    LIMIT 5"; //search query for ajax on all pages that arent results.php
    $query=mysqli_query($conn, $sql);
      while($row=mysqli_fetch_array($query))
      {
        $array[] = array('id'=>$row['id'], 'make'=>$row['make'], 'model'=>$row['model']);
        //return results in an array for json to encode
      }

    echo json_encode($array);
?>
