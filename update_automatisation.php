<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if (isset($_GET['heures_creuses'])) {
		$req = $bdd->prepare('UPDATE automatisation SET heures_creuses = :heures_creuses WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'heures_creuses' => (int)$_GET['heures_creuses'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['donnees_equipement'])) {
		$req = $bdd->prepare('UPDATE automatisation SET donnees_equipement = :donnees_equipement WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'donnees_equipement' => (int)$_GET['donnees_equipement'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['plages_auto']) AND isset($_GET['modif_plage_auto'])) {
		$req = $bdd->prepare('UPDATE automatisation SET plages_auto = :plages_auto, modif_plage_auto = :modif_plage_auto WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'plages_auto' => (int)$_GET['plages_auto'],
			'modif_plage_auto' => (int)$_GET['modif_plage_auto'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['debut_plage_auto'])) {
		$req = $bdd->prepare('UPDATE automatisation SET debut_plage_auto = :debut_plage_auto WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'debut_plage_auto' => (string)$_GET['debut_plage_auto'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['temps_filtration_jour'])) {
		$req = $bdd->prepare('UPDATE automatisation SET temps_filtration_jour = :temps_filtration_jour WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'temps_filtration_jour' => (string)$_GET['temps_filtration_jour'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['plage_auto'])) {
		$req = $bdd->prepare('UPDATE automatisation SET plage_auto = :plage_auto WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'plage_auto' => (string)$_GET['plage_auto'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['asservissement_ph_plus'])) {
		$req = $bdd->prepare('UPDATE automatisation SET asservissement_ph_plus = :asservissement_ph_plus WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'asservissement_ph_plus' => (int)$_GET['asservissement_ph_plus'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['asservissement_ph_moins'])) {
		$req = $bdd->prepare('UPDATE automatisation SET asservissement_ph_moins = :asservissement_ph_moins WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'asservissement_ph_moins' => (int)$_GET['asservissement_ph_moins'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['asservissement_orp'])) {
		$req = $bdd->prepare('UPDATE automatisation SET asservissement_orp = :asservissement_orp WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'asservissement_orp' => (int)$_GET['asservissement_orp'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['consigne_orp_auto'])) {
		$req = $bdd->prepare('UPDATE automatisation SET consigne_orp_auto = :consigne_orp_auto WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'consigne_orp_auto' => (float)$_GET['consigne_orp_auto'],
			'id_systeme' => (int)$result['id']
			));
	}
}
?>