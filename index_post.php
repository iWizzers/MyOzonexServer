<?php
include("bdd_connect.php");

$pass = false;

if (isset($_POST['login']) AND !empty($_POST['id_system'])) {
	//  Récupération du mot de passe hashé
	$req = $bdd->prepare('SELECT id, password FROM login WHERE id_system = :id_system');
	$req->execute(array(
		'id_system' => (string)$_POST['id_system']));
	$result = $req->fetch();

	// Comparaison de l'utilisateur envoyé via le formulaire avec la base
	$isPasswordCorrect = password_verify($_POST['password'], $result['password']);

	if ($result AND $isPasswordCorrect)
	{
		$pass = true;
		session_start();
		$_SESSION['id'] = $result['id'];
		$_SESSION['id_system'] = $_POST['id_system'];

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