<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if (isset($_GET['installe'])) {
		$req = $bdd->prepare('UPDATE filtre SET installe = :installe WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'installe' => (int)$_GET['installe'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['date_dernier_lavage'])) {
		$req = $bdd->prepare('UPDATE filtre SET date_dernier_lavage = :date_dernier_lavage, pression_apres_lavage = :pression_apres_lavage, pression_prochain_lavage = :pression_prochain_lavage WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'date_dernier_lavage' => (string)$_GET['date_dernier_lavage'],
			'pression_apres_lavage' => 0,
			'pression_prochain_lavage' => 0,
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['pression_apres_lavage'])) {
		$req = $bdd->prepare('UPDATE filtre SET pression_apres_lavage = :pression_apres_lavage WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'pression_apres_lavage' => (float)$_GET['pression_apres_lavage'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['pression_prochain_lavage'])) {
		$req = $bdd->prepare('UPDATE filtre SET pression_prochain_lavage = :pression_prochain_lavage WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'pression_prochain_lavage' => (float)$_GET['pression_prochain_lavage'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['seuil_rincage'])) {
		$req = $bdd->prepare('UPDATE filtre SET seuil_rincage = :seuil_rincage WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'seuil_rincage' => (int)$_GET['seuil_rincage'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['seuil_securite_surpression'])) {
		$req = $bdd->prepare('UPDATE filtre SET seuil_securite_surpression = :seuil_securite_surpression WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'seuil_securite_surpression' => (float)$_GET['seuil_securite_surpression'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['seuil_haut_pression'])) {
		$req = $bdd->prepare('UPDATE filtre SET seuil_haut_pression = :seuil_haut_pression WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'seuil_haut_pression' => (float)$_GET['seuil_haut_pression'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['seuil_bas_pression'])) {
		$req = $bdd->prepare('UPDATE filtre SET seuil_bas_pression = :seuil_bas_pression WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'seuil_bas_pression' => (float)$_GET['seuil_bas_pression'],
			'id_systeme' => (int)$result['id']
			));
	}
}
?>