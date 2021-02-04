<?php
include("bdd_connect.php");
include("api.php");


if (isset($_GET['id_systeme'])) {
	if (isset($_GET['password'])) {
		$pass_hache = password_hash($_GET['password'], PASSWORD_DEFAULT);

		if (isset($_GET['piscinier'])) {
			$req = $bdd->prepare('SELECT id FROM pisciniers WHERE nom = :nom');
			$req->execute(array(
				'nom' => (string)$_GET['piscinier']
				));
			$donnees = $req->fetch();
			$req->closeCursor();

			$req = $bdd->prepare('UPDATE pisciniers SET password = :password WHERE id = :id');
			$req->execute(array(
				'password' => $pass_hache,
				'id' => (int)$donnees['id']
				));
		} else {
			$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => (string)$_GET['id_systeme']
				));
			$donnees = $req->fetch();
			$req->closeCursor();

			$req = $bdd->prepare('UPDATE login SET password = :password WHERE id = :id');
			$req->execute(array(
				'password' => $pass_hache,
				'id' => (int)$donnees['id']
				));
		}
	} elseif (isset($_GET['alive'])) {
		include 'create_save.php';

		$req = $bdd->prepare('UPDATE login SET alive = :alive WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'alive' => (string)$_GET['alive'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
		
		if (isset($_GET['raz'])) {
			$date_heure = explode("-", (string)$_GET['alive']);
			$date = date_format(date_create_from_format('d/m/Y', $date_heure[0]), 'd/m/Y');

			$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => (string)$_GET['id_systeme']));
			$result = $req->fetch();

			$req = $bdd->prepare('UPDATE login SET background = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => (string)$_GET['id_systeme']
				));

			$req = $bdd->prepare('UPDATE automatisation SET heures_creuses = DEFAULT, donnees_equipement = DEFAULT, modif_plage_auto = DEFAULT, plages_auto = DEFAULT, debut_plage_auto = DEFAULT,  temps_filtration_jour = DEFAULT, plage_auto = DEFAULT, asservissement_ph_plus = DEFAULT, asservissement_ph_moins = DEFAULT, asservissement_orp = DEFAULT, consigne_orp_auto = DEFAULT, capteur_niveau_eau = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE pompe_filtration SET etat = DEFAULT, lecture_capteurs = DEFAULT, date_consommation = :date_consommation, consommation_hp = DEFAULT, consommation_hc = DEFAULT, plage_1 = DEFAULT, plage_2 = DEFAULT, plage_3 = DEFAULT, plage_4 = DEFAULT, etat_hors_gel = DEFAULT etat_bypass = DEFAULT WHERE id_systeme = :id_systeme');
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

			$req = $bdd->prepare('UPDATE bassin SET temporisation_demarrage = DEFAULT, type_refoulement = DEFAULT, type_regulation = DEFAULT, temps_securite_injection = DEFAULT, hyst_injection_ph = DEFAULT, hyst_injection_orp = DEFAULT, hyst_injection_ampero = DEFAULT, etat_regulations = DEFAULT WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => (int)$result['id']
				));

			$req = $bdd->prepare('UPDATE fontaine SET installe = DEFAULT, etat = DEFAULT, plage_1 = DEFAULT, plage_2 = DEFAULT, plage_3 = DEFAULT, plage_4 = DEFAULT WHERE id_systeme = :id_systeme');
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

			$req = $bdd->prepare('UPDATE capteurs SET installe = 0, etat = DEFAULT, valeur = DEFAULT WHERE id_systeme = :id_systeme AND type = :type');
			$req->execute(array(
				'id_systeme' => (int)$result['id'],
				'type' => "Ampéro DPD4"
				));
		}
	} elseif (isset($_GET['block'])) {
		$req = $bdd->prepare('UPDATE login SET block = :block WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'block' => (int)$_GET['block'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
	} elseif (isset($_GET['background'])) {
		$req = $bdd->prepare('UPDATE login SET background = :background WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'background' => (int)$_GET['background'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
	} elseif (isset($_GET['proprietaire'])) {
		$req = $bdd->prepare('UPDATE login SET proprietaire = :proprietaire WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'proprietaire' => (string)$_GET['proprietaire'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
	} elseif (isset($_GET['coordonnees'])) {
		$req = $bdd->prepare('UPDATE login SET coordonnees = :coordonnees WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'coordonnees' => (string)$_GET['coordonnees'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
	} elseif (isset($_GET['ville'])) {
		$req = $bdd->prepare('UPDATE login SET ville = :ville WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'ville' => (string)$_GET['ville'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
	} elseif (isset($_GET['type_connexion'])) {
		$req = $bdd->prepare('UPDATE login SET type_connexion = :type_connexion WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'type_connexion' => (int)$_GET['type_connexion'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
	} elseif (isset($_GET['version_qseven'])) {
		$req = $bdd->prepare('UPDATE login SET version_qseven = :version_qseven WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'version_qseven' => (int)$_GET['version_qseven'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
	} elseif (isset($_GET['version'])) {
		// Appareil de démonstration
		$req = $bdd->prepare('UPDATE login SET version = :version WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'version' => explode(" - ", (string)$_GET['version'])[1],
			'id_systeme' => 'DEMO-0001'
			));

		// Appareil en cours
		$req = $bdd->prepare('UPDATE login SET version = :version WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'version' => (string)$_GET['version'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
	} elseif (isset($_GET['type_appareil'])) {
		$req = $bdd->prepare('UPDATE login SET type_appareil = :type_appareil WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'type_appareil' => (int)$_GET['type_appareil'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
	} elseif (isset($_GET['piscinier'])) {
		$req = $bdd->prepare('UPDATE login SET piscinier = :piscinier WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'piscinier' => (string)$_GET['piscinier'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
	} elseif (isset($_GET['date_pose'])) {
		$req = $bdd->prepare('UPDATE login SET date_pose = :date_pose WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'date_pose' => (string)$_GET['date_pose'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
	} elseif (isset($_GET['manipulation_client'])) {
		$req = $bdd->prepare('UPDATE login SET manipulation_client = :manipulation_client WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'manipulation_client' => (int)$_GET['manipulation_client'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
	} elseif (isset($_GET['delete'])) {
		$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (string)$_GET['id_systeme']));
		$result = $req->fetch();

		$req = $bdd->prepare('DELETE FROM algicide WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM automatisation WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM bassin WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM capteurs WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM chauffage WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM eclairage WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM electrolyseur WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM events WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM filtre WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM fontaine WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM horlogerie WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM lampes_uv WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM login WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (string)$_GET['id_systeme']
			));

		$req = $bdd->prepare('DELETE FROM messages WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM ozonateur WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM pompe_filtration WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM regulateur_orp WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM regulateur_ph WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM regulateur_ph_moins WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM regulateur_ph_plus WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));

		$req = $bdd->prepare('DELETE FROM surpresseur WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['restart'])) {
		$req = $bdd->prepare('UPDATE login SET restart = :restart WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'restart' => (int)$_GET['restart'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
	}
}
?>