<?php
include("bdd_connect.php");

$dir_name = 'update';

if (isset($_GET['os']) && isset($_GET['version']) && isset($_GET['utilisateur'])) {
	$version = file_get_contents($dir_name . '/version_pc');
	$dir_name = $dir_name . '/' . (string)$_GET['os'] . '/' . (string)$_GET['utilisateur'];
	$zip_name = scandir($dir_name)[2];
	$zip = $dir_name . '/' . $zip_name;

	if (file_exists($zip) && ($version != (string)$_GET['version'])) {
		header('Content-Type: application/exe');
		header('Content-disposition: attachment; filename=' . $zip_name);
		header('Content-Length: ' . filesize($zip));
		readfile($zip);
	}
} elseif (isset($_GET['id_systeme'])) {
	$version = file_get_contents($dir_name . '/version');
	$zip_name = 'app.tar';

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