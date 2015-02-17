<?php
require_once('connect.php');
    $key=$_GET['q'];
    $array = array();
    $sql="SELECT * FROM assets WHERE description like '%$key%'";
    $query=mysqli_query($conn, $sql);
    while($row=mysqli_fetch_array($query))
    {
      $array[] = $row['make'];
    }
    echo json_encode($array);
?>
