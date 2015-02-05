<?php
session_start();
?>
//Gap to start session before echoing anything to page
<?php
include('header.php');
echo "Success! Welcome back ".$_SESSION["first"]."<br>";
?>
