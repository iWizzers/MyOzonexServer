<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if (isset($_GET['point_consigne'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph SET point_consigne = :point_consigne WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'point_consigne' => (float)$_GET['point_consigne'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['hysteresis_plus'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph SET hysteresis_plus = :hysteresis_plus WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'hysteresis_plus' => (float)$_GET['hysteresis_plus'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['hysteresis_moins'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph SET hysteresis_moins = :hysteresis_moins WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'hysteresis_moins' => (float)$_GET['hysteresis_moins'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['alarme_seuil_bas'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph SET alarme_seuil_bas = :alarme_seuil_bas WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'alarme_seuil_bas' => (float)$_GET['alarme_seuil_bas'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['alarme_seuil_haut'])) {
		$req = $bdd->prepare('UPDATE regulateur_ph SET alarme_seuil_haut = :alarme_seuil_haut WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'alarme_seuil_haut' => (float)$_GET['alarme_seuil_haut'],
			'id_systeme' => (int)$result['id']
			));
	}
}
?>