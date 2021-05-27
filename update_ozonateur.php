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
	} elseif (isset($_GET['type_ozone'])) {
		$req = $bdd->prepare('UPDATE ozonateur SET type_ozone = :type_ozone WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'type_ozone' => (string)$_GET['type_ozone'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['nombre_ventilateurs'])) {
		$req = $bdd->prepare('UPDATE ozonateur SET nombre_ventilateurs = :nombre_ventilateurs WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'nombre_ventilateurs' => (int)$_GET['nombre_ventilateurs'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['tempo_ozone'])) {
		$req = $bdd->prepare('UPDATE ozonateur SET tempo_ozone = :tempo_ozone WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'tempo_ozone' => (int)$_GET['tempo_ozone'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['erreurs_ozone'])) {
		$req = $bdd->prepare('UPDATE ozonateur SET erreurs_ozone = :erreurs_ozone WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'erreurs_ozone' => (int)$_GET['erreurs_ozone'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['vitesse_fan_1_ozone'])) {
		$req = $bdd->prepare('UPDATE ozonateur SET vitesse_fan_1_ozone = :vitesse_fan_1_ozone WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'vitesse_fan_1_ozone' => (int)$_GET['vitesse_fan_1_ozone'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['vitesse_fan_2_ozone'])) {
		$req = $bdd->prepare('UPDATE ozonateur SET vitesse_fan_2_ozone = :vitesse_fan_2_ozone WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'vitesse_fan_2_ozone' => (int)$_GET['vitesse_fan_2_ozone'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['courant_alim_ozone'])) {
		$req = $bdd->prepare('UPDATE ozonateur SET courant_alim_ozone = :courant_alim_ozone WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'courant_alim_ozone' => (int)$_GET['courant_alim_ozone'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['tension_alim_ozone'])) {
		$req = $bdd->prepare('UPDATE ozonateur SET tension_alim_ozone = :tension_alim_ozone WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'tension_alim_ozone' => (float)$_GET['tension_alim_ozone'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['haute_tension_alim_ozone'])) {
		$req = $bdd->prepare('UPDATE ozonateur SET haute_tension_alim_ozone = :haute_tension_alim_ozone WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'haute_tension_alim_ozone' => (int)$_GET['haute_tension_alim_ozone'],
			'id_systeme' => (int)$result['id']
			));
	}
}
?>