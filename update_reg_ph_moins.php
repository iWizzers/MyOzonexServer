<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if (isset($_GET['installe'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET installe = :installe WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'installe' => (int)$_GET['installe'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['debit'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET debit = :debit WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'debit' => (float)$_GET['debit'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['etat'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET etat = :etat WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'etat' => (int)$_GET['etat'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['date_consommation']) AND isset($_GET['volume'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET date_consommation = :date_consommation, volume = :volume, volume_restant = :volume_restant WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'date_consommation' => (string)$_GET['date_consommation'],
			'volume' => (float)$_GET['volume'],
			'volume_restant' => (float)$_GET['volume'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['volume_restant'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET volume_restant = :volume_restant WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'volume_restant' => (float)$_GET['volume_restant'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['consommation_jour'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET consommation_jour = :consommation_jour WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'consommation_jour' => (float)$_GET['consommation_jour'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['consommation_semaine'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET consommation_semaine = :consommation_semaine WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'consommation_semaine' => (float)$_GET['consommation_semaine'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['consommation_mois'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET consommation_mois = :consommation_mois WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'consommation_mois' => (float)$_GET['consommation_mois'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['injection'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET injection = :injection WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'injection' => (int)$_GET['injection'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['duree_cycle'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET duree_cycle = :duree_cycle WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'duree_cycle' => (int)$_GET['duree_cycle'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['multiplicateur_diff'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET multiplicateur_diff = :multiplicateur_diff WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'multiplicateur_diff' => (int)$_GET['multiplicateur_diff'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['duree_injection_minimum'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET duree_injection_minimum = :duree_injection_minimum WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'duree_injection_minimum' => (string)$_GET['duree_injection_minimum'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['duree_injection'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET duree_injection = :duree_injection WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'duree_injection' => (string)$_GET['duree_injection'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['temps_reponse'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET temps_reponse = :temps_reponse WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'temps_reponse' => (string)$_GET['temps_reponse'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['temps_injection_jour_max'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET temps_injection_jour_max = :temps_injection_jour_max WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'temps_injection_jour_max' => (int)$_GET['temps_injection_jour_max'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['temps_injection_jour_max_restant'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph_moins SET temps_injection_jour_max_restant = :temps_injection_jour_max_restant WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'temps_injection_jour_max_restant' => (int)$_GET['temps_injection_jour_max_restant'],
			'id_systeme' => (int)$result['id']
			));
	}
}
?>