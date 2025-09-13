<?php
require_once 'includes/config.php';

session_start();

$_SESSION = array();

session_destroy();

header("location: login.php");
exit;
?>