<?php
include("bdd_connect.php");

$pass = false;
$type_appareil = 0;
$proprietaire = "";

if (isset($_GET['piscinier']) AND isset($_GET['password'])) {
	$req = $bdd->prepare('SELECT password FROM pisciniers WHERE nom = :piscinier');
	$req->execute(array(
		'piscinier' => (string)$_GET['piscinier']
	));
	$result = $req->fetch();

	// Comparaison de l'utilisateur envoyé via le formulaire avec la base
	$isPasswordCorrect = password_verify((string)$_GET['password'], (string)$result['password']);

	if ($result AND $isPasswordCorrect) {
		$pass = true;
	}
} elseif (isset($_GET['id_systeme'])) {
	if (isset($_GET['password'])) {
		$req = $bdd->prepare('SELECT id, password, type_appareil, proprietaire FROM login WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (string)$_GET['id_systeme']
		));
		$result = $req->fetch();

		// Comparaison de l'utilisateur envoyé via le formulaire avec la base
		$isPasswordCorrect = password_verify((string)$_GET['password'], (string)$result['password']);

		if ($result AND $isPasswordCorrect) {
			$pass = true;
			$type_appareil = (int)$result['type_appareil'];
			$proprietaire = (string)$result['proprietaire'];
		}
	} elseif (isset($_GET['admin'])) {
		$req = $bdd->prepare('SELECT id, type_appareil, proprietaire FROM login WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (string)$_GET['id_systeme']
		));
		$result = $req->fetch();

		if ((int)$result["id"] > 0) {
			$pass = true;
			$type_appareil = (int)$result['type_appareil'];
			$proprietaire = (string)$result['proprietaire'];
		}
	}
}

if ($pass) {
	echo "LOG OK;" . $type_appareil . ';' . $proprietaire;
} else {
	echo "LOG ERROR";
}
?>