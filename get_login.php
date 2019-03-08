<?php
include("bdd_connect.php");

$pass = false;

if (isset($_GET['id_systeme'])) {
	if (isset($_GET['password'])) {
		$req = $bdd->prepare('SELECT id, password FROM login WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (string)$_GET['id_systeme']
		));
		$result = $req->fetch();

		// Comparaison de l'utilisateur envoyé via le formulaire avec la base
		$isPasswordCorrect = password_verify((string)$_GET['password'], (string)$result['password']);

		if ($result AND $isPasswordCorrect) {
			$pass = true;
		}
	} else if (isset($_GET['admin'])) {
		$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (string)$_GET['id_systeme']
		));
		$result = $req->fetch();

		if ((int)$result["id"] > 0) {
			$pass = true;
		}
	}
}

if ($pass) {
	echo "LOG OK";
} else {
	echo "LOG ERROR";
}
?>