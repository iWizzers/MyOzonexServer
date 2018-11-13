<?php
include("bdd_connect.php");

$pass = false;

if (isset($_POST['login']) AND !empty($_POST['id_systeme']) AND !empty($_POST['password'])) {
	//  Récupération du mot de passe hashé
	$req = $bdd->prepare('SELECT id, password FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_POST['id_systeme']));
	$result = $req->fetch();

	// Comparaison de l'utilisateur envoyé via le formulaire avec la base
	$isPasswordCorrect = password_verify($_POST['password'], $result['password']);

	if ($result AND $isPasswordCorrect)
	{
		$pass = true;
		session_start();
		$_SESSION['id'] = $result['id'];
		$_SESSION['id_systeme'] = $_POST['id_systeme'];

		if ($result['id'] == 1)
		{
			header('Location: root.php');
		}
		else
		{
			header('Location: homepage.php');
		}
	}
}

// Redirection du visiteur vers la page du login
if (!$pass) {
	header('Location: index.php');
}
?>