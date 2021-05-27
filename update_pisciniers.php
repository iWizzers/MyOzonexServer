<?php
include("bdd_connect.php");
include("api.php");


if (isset($_GET['ancien_nom'])) {
	if (isset($_GET['nouveau_nom'])) {
		$req = $bdd->prepare('UPDATE pisciniers SET nom = :nouveau_nom WHERE nom = :ancien_nom');
		$req->execute(array(
			'nouveau_nom' => (string)$_GET['nouveau_nom'],
			'ancien_nom' => (string)$_GET['ancien_nom']
			));

		$req = $bdd->prepare('UPDATE login SET piscinier = :nouveau_nom WHERE piscinier = :ancien_nom');
		$req->execute(array(
			'nouveau_nom' => (string)$_GET['nouveau_nom'],
			'ancien_nom' => (string)$_GET['ancien_nom']
			));
	} elseif (isset($_GET['blocage'])) {
		$req = $bdd->prepare('UPDATE pisciniers SET blocage = :blocage WHERE nom = :ancien_nom');
		$req->execute(array(
			'blocage' => (int)$_GET['blocage'],
			'ancien_nom' => (string)$_GET['ancien_nom']
			));

		$req = $bdd->prepare('UPDATE login SET block = :block WHERE piscinier = :ancien_nom');
		$req->execute(array(
			'block' => (int)$_GET['blocage'],
			'ancien_nom' => (string)$_GET['ancien_nom']
			));
	} elseif (isset($_GET['delete'])) {
		$req = $bdd->prepare('SELECT nom FROM pisciniers ORDER BY id LIMIT 1');
		$req->execute();
		$result = $req->fetch();

		$req = $bdd->prepare('DELETE FROM pisciniers WHERE nom = :nom');
		$req->execute(array(
			'nom' => (string)$_GET['ancien_nom']
			));

		$req = $bdd->prepare('UPDATE login SET piscinier = :nouveau_nom WHERE piscinier = :ancien_nom');
		$req->execute(array(
			'nouveau_nom' => (string)$result['nom'],
			'ancien_nom' => (string)$_GET['ancien_nom']
			));
	}
}
?>