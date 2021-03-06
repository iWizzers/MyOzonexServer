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
	} elseif (isset($_GET['autre'])) {
		$req = $bdd->prepare('UPDATE capteurs SET autre = :autre WHERE id_systeme = :id_systeme AND type = :type');
		$req->execute(array(
			'autre' => (string)$_GET['autre'],
			'id_systeme' => (int)$result['id'],
			'type' => (string)$_GET['type']
			));
	} elseif (isset($_GET['etalonnage']) AND isset($_GET['valeur_etalonnage'])) {
		$req = $bdd->prepare('UPDATE capteurs SET etalonnage = :etalonnage, valeur_etalonnage = :valeur_etalonnage WHERE id_systeme = :id_systeme AND type = :type');
		$req->execute(array(
			'etalonnage' => (int)$_GET['etalonnage'],
			'valeur_etalonnage' => (float)$_GET['valeur_etalonnage'],
			'id_systeme' => (int)$result['id'],
			'type' => (string)$_GET['type']
			));
	} elseif (isset($_GET['couleur_home'])) {
		$req = $bdd->prepare('UPDATE capteurs SET couleur_home = :couleur_home WHERE id_systeme = :id_systeme AND type = :type');
		$req->execute(array(
			'couleur_home' => '#' . (string)$_GET['couleur_home'],
			'id_systeme' => (int)$result['id'],
			'type' => (string)$_GET['type']
			));
	} elseif (isset($_GET['couleur_synoptique'])) {
		$req = $bdd->prepare('UPDATE capteurs SET couleur_synoptique = :couleur_synoptique WHERE id_systeme = :id_systeme AND type = :type');
		$req->execute(array(
			'couleur_synoptique' => '#' . (string)$_GET['couleur_synoptique'],
			'id_systeme' => (int)$result['id'],
			'type' => (string)$_GET['type']
			));
	}
}
?>