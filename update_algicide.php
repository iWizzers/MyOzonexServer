<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if (isset($_GET['installe'])) {
		$req = $bdd->prepare('UPDATE algicide SET installe = :installe WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'installe' => (int)$_GET['installe'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['etat'])) {
		$req = $bdd->prepare('UPDATE algicide SET etat = :etat WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'etat' => (int)$_GET['etat'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['date_consommation']) AND isset($_GET['volume'])) {
		$req = $bdd->prepare('UPDATE algicide SET date_consommation = :date_consommation, volume = :volume, volume_restant = :volume_restant WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'date_consommation' => (string)$_GET['date_consommation'],
			'volume' => (float)$_GET['volume'],
			'volume_restant' => (float)$_GET['volume'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['volume_restant'])) {
		$req = $bdd->prepare('UPDATE algicide SET volume_restant = :volume_restant WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'volume_restant' => (float)$_GET['volume_restant'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['injection'])) {
		$req = $bdd->prepare('UPDATE algicide SET injection = :injection WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'injection' => (int)$_GET['injection'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['active'])) {
		$req = $bdd->prepare('UPDATE algicide SET active = :active WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'active' => (int)$_GET['active'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['frequence'])) {
		$req = $bdd->prepare('UPDATE algicide SET frequence = :frequence WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'frequence' => (string)$_GET['frequence'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['pendant'])) {
		$req = $bdd->prepare('UPDATE algicide SET pendant = :pendant WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'pendant' => (int)$_GET['pendant'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['prochain'])) {
		$req = $bdd->prepare('UPDATE algicide SET prochain = :prochain WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'prochain' => (int)$_GET['prochain'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['temps_restant'])) {
		$req = $bdd->prepare('UPDATE algicide SET temps_restant = :temps_restant WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'temps_restant' => (int)$_GET['temps_restant'],
			'id_systeme' => (int)$result['id']
			));
	}
}
?>