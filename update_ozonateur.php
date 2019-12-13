<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if (isset($_GET['installe'])) {
		$req = $bdd->prepare('UPDATE ozonateur SET installe = :installe WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'installe' => (int)$_GET['installe'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['etat'])) {
		$req = $bdd->prepare('UPDATE ozonateur SET etat = :etat WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'etat' => (int)$_GET['etat'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['date_consommation'])) {
		$req = $bdd->prepare('UPDATE ozonateur SET date_consommation = :date_consommation, consommation_hp = :consommation_hp, consommation_hc = :consommation_hc WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'date_consommation' => (string)$_GET['date_consommation'],
			'consommation_hp' => 0,
			'consommation_hc' => 0,
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['consommation_hp'])) {
		$req = $bdd->prepare('UPDATE ozonateur SET consommation_hp = :consommation_hp WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'consommation_hp' => (float)$_GET['consommation_hp'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['consommation_hc'])) {
		$req = $bdd->prepare('UPDATE ozonateur SET consommation_hc = :consommation_hc WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'consommation_hc' => (float)$_GET['consommation_hc'],
			'id_systeme' => (int)$result['id']
			));
	}
}
?>