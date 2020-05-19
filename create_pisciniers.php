<?php
include("bdd_connect.php");

$pass = false;

if (isset($_GET['nom']) AND isset($_GET['password'])) {
	// Vérifie si la base de données de l'utilisateur existe
	$req = $bdd->prepare('SELECT EXISTS (SELECT * FROM pisciniers WHERE nom = :nom) AS piscinier_exists');
	$req->execute(array(
		'nom' => (string)$_GET['nom']));
	$result = $req->fetch();

	if (!$result['piscinier_exists']) {
		// Hachage du mot de passe
		$pass_hache = password_hash($_GET['password'], PASSWORD_DEFAULT);

		// Création du nouvel utilisateur
		$req = $bdd->prepare('INSERT INTO pisciniers(nom, password) VALUES(:nom, :password)');
		$req->execute(array(
			'nom' => (string)$_GET['nom'],
			'password' => $pass_hache
		));

		$pass = "LOG OK";
	} else {
		$pass = "LOG EXISTS";
	}
} else {
	$pass = "LOG ERROR";
}

echo $pass;
?>