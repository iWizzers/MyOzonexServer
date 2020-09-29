<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if (isset($_GET['installe'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET installe = :installe WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'installe' => (int)$_GET['installe'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['point_consigne_orp'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET point_consigne_orp = :point_consigne_orp WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'point_consigne_orp' => (int)$_GET['point_consigne_orp'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['hysteresis_orp'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET hysteresis_orp = :hysteresis_orp WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'hysteresis_orp' => (int)$_GET['hysteresis_orp'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['point_consigne_ampero'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET point_consigne_ampero = :point_consigne_ampero WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'point_consigne_ampero' => (float)$_GET['point_consigne_ampero'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['hysteresis_ampero'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET hysteresis_ampero = :hysteresis_ampero WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'hysteresis_ampero' => (float)$_GET['hysteresis_ampero'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['chlore_libre_actif'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET chlore_libre_actif = :chlore_libre_actif WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'chlore_libre_actif' => (float)$_GET['chlore_libre_actif'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['etat'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET etat = :etat WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'etat' => (int)$_GET['etat'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['date_consommation']) AND isset($_GET['volume'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET date_consommation = :date_consommation, volume = :volume, volume_restant = :volume_restant WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'date_consommation' => (string)$_GET['date_consommation'],
			'volume' => (float)$_GET['volume'],
			'volume_restant' => (float)$_GET['volume'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['volume_restant'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET volume_restant = :volume_restant WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'volume_restant' => (float)$_GET['volume_restant'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['consommation_jour'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET consommation_jour = :consommation_jour WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'consommation_jour' => (float)$_GET['consommation_jour'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['consommation_semaine'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET consommation_semaine = :consommation_semaine WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'consommation_semaine' => (float)$_GET['consommation_semaine'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['consommation_mois'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET consommation_mois = :consommation_mois WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'consommation_mois' => (float)$_GET['consommation_mois'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['injection'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET injection = :injection WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'injection' => (int)$_GET['injection'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['duree_cycle'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET duree_cycle = :duree_cycle WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'duree_cycle' => (int)$_GET['duree_cycle'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['multiplicateur_diff'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET multiplicateur_diff = :multiplicateur_diff WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'multiplicateur_diff' => (int)$_GET['multiplicateur_diff'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['duree_injection_minimum'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET duree_injection_minimum = :duree_injection_minimum WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'duree_injection_minimum' => (string)$_GET['duree_injection_minimum'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['duree_injection'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET duree_injection = :duree_injection WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'duree_injection' => (string)$_GET['duree_injection'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['temps_reponse'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET temps_reponse = :temps_reponse WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'temps_reponse' => (string)$_GET['temps_reponse'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['temps_injection_jour_max'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET temps_injection_jour_max = :temps_injection_jour_max WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'temps_injection_jour_max' => (int)$_GET['temps_injection_jour_max'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['temps_injection_jour_max_restant'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET temps_injection_jour_max_restant = :temps_injection_jour_max_restant WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'temps_injection_jour_max_restant' => (int)$_GET['temps_injection_jour_max_restant'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['surchloration'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET surchloration = :surchloration WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'surchloration' => (int)$_GET['surchloration'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['frequence'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET frequence = :frequence WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'frequence' => (string)$_GET['frequence'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['mv_ajoute'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET mv_ajoute = :mv_ajoute WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'mv_ajoute' => (int)$_GET['mv_ajoute'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['prochaine_surchloration'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET prochaine_surchloration = :prochaine_surchloration WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'prochaine_surchloration' => (int)$_GET['prochaine_surchloration'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['alarme_seuil_bas_ampero'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET alarme_seuil_bas_ampero = :alarme_seuil_bas_ampero WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'alarme_seuil_bas_ampero' => (float)$_GET['alarme_seuil_bas_ampero'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['alarme_seuil_haut_ampero'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET alarme_seuil_haut_ampero = :alarme_seuil_haut_ampero WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'alarme_seuil_haut_ampero' => (float)$_GET['alarme_seuil_haut_ampero'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['alarme_seuil_bas_orp'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET alarme_seuil_bas_orp = :alarme_seuil_bas_orp WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'alarme_seuil_bas_orp' => (int)$_GET['alarme_seuil_bas_orp'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['alarme_seuil_haut_orp'])) {
		$req = $bdd->prepare('UPDATE regulateur_orp SET alarme_seuil_haut_orp = :alarme_seuil_haut_orp WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'alarme_seuil_haut_orp' => (int)$_GET['alarme_seuil_haut_orp'],
			'id_systeme' => (int)$result['id']
			));
	}
}
?>