<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if (isset($_GET['volume'])) {
		$req = $bdd->prepare('UPDATE bassin SET volume = :volume WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'volume' => (int)$_GET['volume'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['type_refoulement'])) {
		$req = $bdd->prepare('UPDATE bassin SET type_refoulement = :type_refoulement WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'type_refoulement' => (string)$_GET['type_refoulement'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['type_regulation'])) {
		$req = $bdd->prepare('UPDATE bassin SET type_regulation = :type_regulation WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'type_regulation' => (string)$_GET['type_regulation'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['temps_securite_injection'])) {
		$req = $bdd->prepare('UPDATE bassin SET temps_securite_injection = :temps_securite_injection WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'temps_securite_injection' => (int)$_GET['temps_securite_injection'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['hyst_injection_ph'])) {
		$req = $bdd->prepare('UPDATE bassin SET hyst_injection_ph = :hyst_injection_ph WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'hyst_injection_ph' => (float)$_GET['hyst_injection_ph'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['hyst_injection_orp'])) {
		$req = $bdd->prepare('UPDATE bassin SET hyst_injection_orp = :hyst_injection_orp WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'hyst_injection_orp' => (int)$_GET['hyst_injection_orp'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['hyst_injection_ampero'])) {
		$req = $bdd->prepare('UPDATE bassin SET hyst_injection_ampero = :hyst_injection_ampero WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'hyst_injection_ampero' => (float)$_GET['hyst_injection_ampero'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['etat_regulations'])) {
		$req = $bdd->prepare('UPDATE bassin SET etat_regulations = :etat_regulations WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'etat_regulations' => (float)$_GET['etat_regulations'],
			'id_systeme' => (int)$result['id']
			));
	}
}
?>