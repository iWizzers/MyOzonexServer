<?php
include("bdd_connect.php");

if (isset($_GET['timezone'])) {
	date_default_timezone_set($_GET['timezone']);
	echo date('d/m/Y-H:i:s');
}
?>