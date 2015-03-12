<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/connect.php";
include_once($path);
$loanNumber = isset($_POST['loanNumber']) ? isset($_POST['loanNumber']) : null;
$lateNotes=$_POST['dateNotes'];



?>
