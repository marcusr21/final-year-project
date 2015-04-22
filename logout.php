<?php
session_start();
session_destroy();
header('Location: index.php');
//destroy all sessions
?>
