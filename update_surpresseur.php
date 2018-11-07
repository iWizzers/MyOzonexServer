<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if (isset($_GET['installe'])) {
		$req = $bdd->prepare('UPDATE surpresseur SET installe = :installe WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'installe' => (int)$_GET['installe'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['etat'])) {
		$req = $bdd->prepare('UPDATE surpresseur SET etat = :etat WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'etat' => (int)$_GET['etat'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['date_consommation'])) {
		$req = $bdd->prepare('UPDATE surpresseur SET date_consommation = :date_consommation, consommation_hp = :consommation_hp, consommation_hc = :consommation_hc WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'date_consommation' => (string)$_GET['date_consommation'],
			'consommation_hp' => 0,
			'consommation_hc' => 0,
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['consommation_hp'])) {
		$req = $bdd->prepare('UPDATE surpresseur SET consommation_hp = :consommation_hp WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'consommation_hp' => (float)$_GET['consommation_hp'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['consommation_hc'])) {
		$req = $bdd->prepare('UPDATE surpresseur SET consommation_hc = :consommation_hc WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'consommation_hc' => (float)$_GET['consommation_hc'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['plage_1'])) {
		$req = $bdd->prepare('UPDATE surpresseur SET plage_1 = :plage_1 WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'plage_1' => (string)$_GET['plage_1'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['plage_2'])) {
		$req = $bdd->prepare('UPDATE surpresseur SET plage_2 = :plage_2 WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'plage_2' => (string)$_GET['plage_2'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['plage_3'])) {
		$req = $bdd->prepare('UPDATE surpresseur SET plage_3 = :plage_3 WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'plage_3' => (string)$_GET['plage_3'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['plage_4'])) {
		$req = $bdd->prepare('UPDATE surpresseur SET plage_4 = :plage_4 WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'plage_4' => (string)$_GET['plage_4'],
			'id_systeme' => (int)$result['id']
			));
	}
}
?>