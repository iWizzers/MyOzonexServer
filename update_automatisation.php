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
			'donnees_equipement' => (string)$_GET['donnees_equipement'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['plages_auto'])) {
		$req = $bdd->prepare('UPDATE automatisation SET plages_auto = :plages_auto WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'plages_auto' => (string)$_GET['plages_auto'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['donnees_asservissements'])) {
		$req = $bdd->prepare('UPDATE automatisation SET donnees_asservissements = :donnees_asservissements WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'donnees_asservissements' => (int)$_GET['donnees_asservissements'],
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