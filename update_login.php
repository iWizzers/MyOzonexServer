<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	if (isset($_GET['alive'])) {
		if (isset($_GET['raz'])) {
			$date_heure = explode("-", (string)$_GET['alive']);
			$date = date_format(date_create_from_format('d/m/Y', $date_heure[0]), 'd/m/Y');

			$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => (string)$_GET['id_systeme']));
			$result = $req->fetch();

			$req = $bdd->prepare('UPDATE login SET background = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $_GET['id_systeme']
				));

			$req = $bdd->prepare('UPDATE automatisation SET heures_creuses = DEFAULT, donnees_equipement = DEFAULT, plages_auto = DEFAULT, donnees_asservissements = DEFAULT, consigne_orp_auto = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE pompe_filtration SET etat = DEFAULT, lecture_capteurs = DEFAULT, date_consommation = :date_consommation, consommation_hp = DEFAULT, consommation_hc = DEFAULT, plage_1 = DEFAULT, plage_2 = DEFAULT, plage_3 = DEFAULT, plage_4 = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'date_consommation' => $date,
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE filtre SET date_dernier_lavage = :date_dernier_lavage, pression_apres_lavage = DEFAULT, pression_prochain_lavage = DEFAULT, seuil_securite_surpression = DEFAULT, seuil_haut_pression = DEFAULT, seuil_bas_pression = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'date_dernier_lavage' => $date,
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE surpresseur SET installe = DEFAULT, etat = DEFAULT, date_consommation = :date_consommation, consommation_hp = DEFAULT, consommation_hc = DEFAULT, plage_1 = DEFAULT, plage_2 = DEFAULT, plage_3 = DEFAULT, plage_4 = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'date_consommation' => $date,
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE chauffage SET installe = DEFAULT, type_chauffage = DEFAULT, etat = DEFAULT, date_consommation = :date_consommation, consommation_hp = DEFAULT, consommation_hc = DEFAULT, gestion_temperature = DEFAULT, temperature_arret = DEFAULT, temperature_encl = DEFAULT, temperature_consigne = DEFAULT, plage_1 = DEFAULT, plage_2 = DEFAULT, plage_3 = DEFAULT, plage_4 = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'date_consommation' => $date,
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE ozonateur SET installe = DEFAULT, etat = DEFAULT, date_consommation = :date_consommation, consommation_hp = DEFAULT, consommation_hc = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'date_consommation' => $date,
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE lampes_uv SET installe = DEFAULT, etat = DEFAULT, date_consommation = :date_consommation, consommation_hp = DEFAULT, consommation_hc = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'date_consommation' => $date,
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE electrolyseur SET installe = DEFAULT, etat = DEFAULT, date_consommation = :date_consommation, consommation_hp = DEFAULT, consommation_hc = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'date_consommation' => $date,
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE regulateur_ph SET point_consigne = DEFAULT, hysteresis_plus = DEFAULT, hysteresis_moins = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE regulateur_ph_plus SET installe = DEFAULT, etat = DEFAULT, date_consommation = :date_consommation, volume = DEFAULT, volume_restant = DEFAULT, consommation_jour = DEFAULT, consommation_semaine = DEFAULT, consommation_mois = DEFAULT, injection = DEFAULT, duree_cycle = DEFAULT, multiplicateur_diff = DEFAULT, duree_injection = DEFAULT, temps_reponse = DEFAULT, temps_injection_jour_max = DEFAULT, temps_injection_jour_max_restant = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'date_consommation' => $date,
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE regulateur_ph_moins SET installe = DEFAULT, etat = DEFAULT, date_consommation = :date_consommation, volume = DEFAULT, volume_restant = DEFAULT, consommation_jour = DEFAULT, consommation_semaine = DEFAULT, consommation_mois = DEFAULT, injection = DEFAULT, duree_cycle = DEFAULT, multiplicateur_diff = DEFAULT, duree_injection = DEFAULT, temps_reponse = DEFAULT, temps_injection_jour_max = DEFAULT, temps_injection_jour_max_restant = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'date_consommation' => $date,
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE regulateur_orp SET installe = DEFAULT, point_consigne_orp = DEFAULT, hysteresis_orp = DEFAULT, point_consigne_ampero = DEFAULT, hysteresis_ampero = DEFAULT, chlore_libre_actif = DEFAULT, etat = DEFAULT, date_consommation = :date_consommation, volume = DEFAULT, volume_restant = DEFAULT, consommation_jour = DEFAULT, consommation_semaine = DEFAULT, consommation_mois = DEFAULT, injection = DEFAULT, duree_cycle = DEFAULT, multiplicateur_diff = DEFAULT, duree_injection = DEFAULT, temps_reponse = DEFAULT, temps_injection_jour_max = DEFAULT, temps_injection_jour_max_restant = DEFAULT, surchloration = DEFAULT, frequence = DEFAULT, mv_ajoute = DEFAULT, prochaine_surchloration = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'date_consommation' => $date,
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE algicide SET installe = DEFAULT, etat = DEFAULT, date_consommation = :date_consommation, volume = DEFAULT, volume_restant = DEFAULT, injection = DEFAULT, active = DEFAULT, frequence = DEFAULT, pendant = DEFAULT, prochain = DEFAULT, temps_restant = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'date_consommation' => $date,
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE eclairage SET installe = DEFAULT, etat = DEFAULT, plage_1 = DEFAULT, plage_2 = DEFAULT, plage_3 = DEFAULT, plage_4 = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE bassin SET type_refoulement = DEFAULT, type_regulation = DEFAULT, temps_securite_injection = DEFAULT, hyst_injection_ph = DEFAULT, hyst_injection_orp = DEFAULT, hyst_injection_ampero = DEFAULT, etat_regulations = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE horlogerie SET plage_1 = DEFAULT, plage_2 = DEFAULT, plage_3 = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => (int)$result['id']
				));

			/*$req = $bdd->prepare('UPDATE capteurs SET installe = 1, etat = DEFAULT, valeur = DEFAULT WHERE id_systeme = :id_systeme AND type = :type');
			$req->execute(array(
				'id_systeme' => (int)$result['id'],
				'type' => "Température bassin"
				));*/

			$req = $bdd->prepare('UPDATE capteurs SET installe = 0, etat = DEFAULT, valeur = DEFAULT WHERE id_systeme = :id_systeme AND type = :type');
			$req->execute(array(
				'id_systeme' => (int)$result['id'],
				'type' => "Température interne"
				));

			$req = $bdd->prepare('UPDATE capteurs SET installe = 0, etat = DEFAULT, valeur = DEFAULT WHERE id_systeme = :id_systeme AND type = :type');
			$req->execute(array(
				'id_systeme' => (int)$result['id'],
				'type' => "Humidité interne"
				));

			$req = $bdd->prepare('UPDATE capteurs SET installe = 0, etat = DEFAULT, valeur = DEFAULT WHERE id_systeme = :id_systeme AND type = :type');
			$req->execute(array(
				'id_systeme' => (int)$result['id'],
				'type' => "Pression atmosphérique interne"
				));

			$req = $bdd->prepare('UPDATE capteurs SET installe = 0, etat = DEFAULT, valeur = DEFAULT WHERE id_systeme = :id_systeme AND type = :type');
			$req->execute(array(
				'id_systeme' => (int)$result['id'],
				'type' => "Température externe"
				));

			$req = $bdd->prepare('UPDATE capteurs SET installe = 0, etat = DEFAULT, valeur = DEFAULT WHERE id_systeme = :id_systeme AND type = :type');
			$req->execute(array(
				'id_systeme' => (int)$result['id'],
				'type' => "Humidité externe"
				));

			$req = $bdd->prepare('UPDATE capteurs SET installe = 0, etat = DEFAULT, valeur = DEFAULT WHERE id_systeme = :id_systeme AND type = :type');
			$req->execute(array(
				'id_systeme' => (int)$result['id'],
				'type' => "Pression atmosphérique externe"
				));

			/*$req = $bdd->prepare('UPDATE capteurs SET installe = 1, etat = DEFAULT, valeur = DEFAULT WHERE id_systeme = :id_systeme AND type = :type');
			$req->execute(array(
				'id_systeme' => (int)$result['id'],
				'type' => "pH"
				));*/

			/*$req = $bdd->prepare('UPDATE capteurs SET installe = 1, etat = DEFAULT, valeur = DEFAULT WHERE id_systeme = :id_systeme AND type = :type');
			$req->execute(array(
				'id_systeme' => (int)$result['id'],
				'type' => "ORP"
				));*/

			$req = $bdd->prepare('UPDATE capteurs SET installe = 0, etat = DEFAULT, valeur = DEFAULT WHERE id_systeme = :id_systeme AND type = :type');
			$req->execute(array(
				'id_systeme' => (int)$result['id'],
				'type' => "Pression"
				));

			$req = $bdd->prepare('UPDATE capteurs SET installe = 0, etat = DEFAULT, valeur = DEFAULT WHERE id_systeme = :id_systeme AND type = :type');
			$req->execute(array(
				'id_systeme' => (int)$result['id'],
				'type' => "Ampéro"
				));
		} else {
			$req = $bdd->prepare('UPDATE login SET alive = :alive WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'alive' => (string)$_GET['alive'],
			'id_systeme' => $_GET['id_systeme']
			));
	}
	} elseif (isset($_GET['block'])) {
		$req = $bdd->prepare('UPDATE login SET block = :block WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'block' => (int)$_GET['block'],
			'id_systeme' => $_GET['id_systeme']
			));
	} elseif (isset($_GET['background'])) {
		$req = $bdd->prepare('UPDATE login SET background = :background WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'background' => (int)$_GET['background'],
			'id_systeme' => $_GET['id_systeme']
			));
	} elseif (isset($_GET['proprietaire'])) {
		$req = $bdd->prepare('UPDATE login SET proprietaire = :proprietaire WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'proprietaire' => (string)$_GET['proprietaire'],
			'id_systeme' => $_GET['id_systeme']
			));
	} elseif (isset($_GET['version'])) {
		$req = $bdd->prepare('UPDATE login SET version = :version WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'version' => (string)$_GET['version'],
			'id_systeme' => $_GET['id_systeme']
			));
	}
}
?>