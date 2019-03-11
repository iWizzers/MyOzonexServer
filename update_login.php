<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	if (isset($_GET['alive'])) {
		$req = $bdd->prepare('UPDATE login SET alive = :alive WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'alive' => (string)$_GET['alive'],
			'id_systeme' => $_GET['id_systeme']
			));
	} elseif (isset($_GET['block'])) {
		$req = $bdd->prepare('UPDATE login SET block = :block WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'block' => (int)$_GET['block'],
			'id_systeme' => $_GET['id_systeme']
			));
	} elseif (isset($_GET['background'])) {
		$req = $bdd->prepare('UPDATE login SET background = :background WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'background' => (int)$_GET['background'],
			'id_systeme' => $_GET['id_systeme']
			));
	} elseif (isset($_GET['proprietaire'])) {
		$req = $bdd->prepare('UPDATE login SET proprietaire = :proprietaire WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'proprietaire' => (string)$_GET['proprietaire'],
			'id_systeme' => $_GET['id_systeme']
			));
	} elseif (isset($_GET['version'])) {
		$req = $bdd->prepare('UPDATE login SET version = :version WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'version' => (string)$_GET['version'],
			'id_systeme' => $_GET['id_systeme']
			));
	}
}
?>