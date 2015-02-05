<?php
session_start();
//gap to start session
?>
<?php
include('header.php');
echo "Success! Welcome back ".$_SESSION["first"]."<br>";
?>
