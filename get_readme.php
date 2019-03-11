<?php
include("bdd_connect.php");

$file = 'README';

if (file_exists($file)) {
	header('Content-Type: application/octet-stream');
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-disposition: attachment; filename=\"" . basename($file) . "\"");
	readfile($file);
}
?>