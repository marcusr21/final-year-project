<?php
    $key=$_GET['key'];
    $array = array();
    $conn=mysqli_connect("localhost","root","toor", "nsumedia2");
    $query=mysql_query("select * from assets where description LIKE '%{$key}%'");
    while($row=mysql_fetch_assoc($query))
    {
      $array[] = $row['title'];
    }
    echo json_encode($array);
?>
