<?php
include("bdd_connect.php");

$file = 'Piscine';

if (file_exists($file) AND isset($_GET['filesize'])) {
	if (filesize($file) != (int)$_GET['filesize']) {
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary"); 
		header("Content-disposition: attachment; filename=\"" . basename($file) . "\"");
		readfile($file);
	}
}
?>