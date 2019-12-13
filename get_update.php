<?php
include("bdd_connect.php");

$dir_name = 'update';
$version = file_get_contents($dir_name . '/version');
$zip_name = 'app.tar';

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT version_qseven, version FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if ((int)$result['version_qseven'] == 1) {
		$dir_name = $dir_name . '/B1';
	} elseif ((int)$result['version_qseven'] == 2) {
		$dir_name = $dir_name . '/B4';
	}

	$zip = $dir_name . '/' . $zip_name;

	if (file_exists($zip) && ($version != (string)$result['version'])) {
		header('Content-Type: application/zip');
		header('Content-disposition: attachment; filename=' . $zip_name);
		header('Content-Length: ' . filesize($zip));
		readfile($zip);
	}
}
?>