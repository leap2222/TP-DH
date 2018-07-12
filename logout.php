<?php
	session_start();
	setcookie('id', '', time()-300);
	session_destroy();
	header('location: login.php');
	exit;
?>
