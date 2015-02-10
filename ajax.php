<?php
if(isset($_POST['end']))
{
  $end = $_POST['end'];
  $json=array('end'=>$end);
}
if(isset($_POST['start']))
{
  $start = $_POST['start'];
  $json = array('start'=>$start);
}
header("Content-Type: application/json");
echo json_encode($json);
?>
