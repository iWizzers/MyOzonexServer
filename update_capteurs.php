<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme']) AND isset($_GET['type'])) {
	$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if (isset($_GET['installe'])) {
		$req = $bdd->prepare('UPDATE capteurs SET installe = :installe WHERE id_systeme = :id_systeme AND type = :type');
		$req->execute(array(
			'installe' => (int)$_GET['installe'],
			'id_systeme' => (int)$result['id'],
			'type' => (string)$_GET['type']
			));
	} elseif (isset($_GET['etat']) AND isset($_GET['valeur'])) {
		$req = $bdd->prepare('UPDATE capteurs SET etat = :etat, valeur = :valeur WHERE id_systeme = :id_systeme AND type = :type');
		$req->execute(array(
			'etat' => (string)$_GET['etat'],
			'valeur' => (float)$_GET['valeur'],
			'id_systeme' => (int)$result['id'],
			'type' => (string)$_GET['type']
			));
	}
}
?>