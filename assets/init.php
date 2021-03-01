<?php 
	$db = new mysqli('127.0.0.1', 'root', '', 'bestilorm');
	$db->query("SET NAMES 'utf8'");

	if(!$db) {
		echo 'Failed to connect to the database.';
		die();
	}

	
 ?>