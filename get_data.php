<?php
include("bdd_connect.php");

header('Content-Type: application/json');

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT * FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']
	));
	$donnees = $req->fetch();

	$id = (int)$donnees['id'];

	if (count(explode(" - ", (string)$donnees['version'])) == 2) {
		$version = explode(" - ", (string)$donnees['version'])[1];
	} else {
		$version = (string)$donnees['version'];
	}

	if ($id != null) {
		if ((string)$_GET['type_donnees'] != "bracket") {
			// Système
			if ((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '3') && (explode(".", $version)[1] < '6')) {
				$data_systeme = array(
					'alive' => (string)$donnees['alive'],
					'blocage' => (int)$donnees['block'],
					'background' => (int)$donnees['background'],
					'restart' => (int)$donnees['restart'],
					'version' => $version
				);
			} elseif (((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '6')) || ((explode(".", $version)[0] > '2'))) {
				$data_systeme = array(
					'alive' => (string)$donnees['alive'],
					'blocage' => (int)$donnees['block'],
					'background' => (int)$donnees['background'],
					'manipulation_client' => (int)$donnees['manipulation_client'],
					'restart' => (int)$donnees['restart'],
					'version' => $version
				);
			} else {
				$data_systeme = array(
					'alive' => (string)$donnees['alive'],
					'blocage' => (int)$donnees['block'],
					'background' => (int)$donnees['background']
				);
			}

			$req->closeCursor();

			// Events
			$req = $bdd->prepare('SELECT * FROM events WHERE id_systeme = :id_systeme ORDER BY id DESC');
			$req->execute(array(
				'id_systeme' => $id
				));

			$data_events = array();
			$i = 0;
			while ($donnees = $req->fetch())
			{
				$data = [ "texte" => (string)$donnees['texte'], "couleur" => (int)$donnees['couleur'], "dateheure" => (string)$donnees['dateheure'], "lu" => (int)$donnees['lu'] ];
				$data_events += [ "event" . strval(++$i) => $data ];
			}

			$req->closeCursor();

			// Automatisation
			$req = $bdd->prepare('SELECT * FROM automatisation WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			if ((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '6') && (explode(".", $version)[2] >= '1')) {
				$data_automatisation = array(
					'heures_creuses' => (int)$donnees['heures_creuses'],
					'donnees_equipement' => (int)$donnees['donnees_equipement'],
					'modif_plage_auto' => (int)$donnees['modif_plage_auto'],
					'plages_auto' => (int)$donnees['plages_auto'],
					'debut_plage_auto' => (string)$donnees['debut_plage_auto'],
					'temps_filtration_jour' => (string)$donnees['temps_filtration_jour'],
					'plage_auto' => (string)$donnees['plage_auto'],
					'asservissement_ph_plus' => (int)$donnees['asservissement_ph_plus'],
					'asservissement_ph_moins' => (int)$donnees['asservissement_ph_moins'],
					'asservissement_orp' => (int)$donnees['asservissement_orp'],
					'consigne_orp_auto' => (int)$donnees['consigne_orp_auto'],
					'capteur_niveau_eau' => (int)$donnees['capteur_niveau_eau']
				);
			} else {
				$data_automatisation = array(
					'heures_creuses' => (int)$donnees['heures_creuses'],
					'donnees_equipement' => (int)$donnees['donnees_equipement'],
					'modif_plage_auto' => (int)$donnees['modif_plage_auto'],
					'plages_auto' => (int)$donnees['plages_auto'],
					'debut_plage_auto' => (string)$donnees['debut_plage_auto'],
					'temps_filtration_jour' => (string)$donnees['temps_filtration_jour'],
					'plage_auto' => (string)$donnees['plage_auto'],
					'asservissement_ph_plus' => (int)$donnees['asservissement_ph_plus'],
					'asservissement_ph_moins' => (int)$donnees['asservissement_ph_moins'],
					'asservissement_orp' => (int)$donnees['asservissement_orp'],
					'consigne_orp_auto' => (int)$donnees['consigne_orp_auto']
				);
			}

			// Horlogerie
			$req = $bdd->prepare('SELECT * FROM horlogerie WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			$data_horlogerie = array(
				'index_gmt' => (string)$donnees['index_gmt'],
				'plage_1' => (string)$donnees['plage_1'],
				'plage_2' => (string)$donnees['plage_2'],
				'plage_3' => (string)$donnees['plage_3']
			);

			$req->closeCursor();

			// Bassin
			$req = $bdd->prepare('SELECT * FROM bassin WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			if ((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '6') && (explode(".", $version)[2] >= '1')) {
				$data_bassin = array(
					'volume' => (int)$donnees['volume'],
					'temporisation_demarrage' => (int)$donnees['temporisation_demarrage'],
					'type_refoulement' => (string)$donnees['type_refoulement'],
					'type_regulation' => (string)$donnees['type_regulation'],
					'temps_securite_injection' => (int)$donnees['temps_securite_injection'],
					'hyst_injection_ph' => (float)$donnees['hyst_injection_ph'],
					'hyst_injection_orp' => (int)$donnees['hyst_injection_orp'],
					'hyst_injection_ampero' => (float)$donnees['hyst_injection_ampero'],
					'etat_regulations' => (int)$donnees['etat_regulations']
				);
			} else {
				$data_bassin = array(
					'volume' => (int)$donnees['volume'],
					'type_refoulement' => (string)$donnees['type_refoulement'],
					'type_regulation' => (string)$donnees['type_regulation'],
					'temps_securite_injection' => (int)$donnees['temps_securite_injection'],
					'hyst_injection_ph' => (float)$donnees['hyst_injection_ph'],
					'hyst_injection_orp' => (int)$donnees['hyst_injection_orp'],
					'hyst_injection_ampero' => (float)$donnees['hyst_injection_ampero'],
					'etat_regulations' => (int)$donnees['etat_regulations']
				);
			}

			$req->closeCursor();


			// Eclairage
			$req = $bdd->prepare('SELECT * FROM eclairage WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			$data_eclairage = array(
				'installe' => (int)$donnees['installe'],
				'etat' => (int)$donnees['etat'],
				'plage_1' => (string)$donnees['plage_1'],
				'plage_2' => (string)$donnees['plage_2'],
				'plage_3' => (string)$donnees['plage_3'],
				'plage_4' => (string)$donnees['plage_4']
			);

			$req->closeCursor();


			// Pompe filtration
			$req = $bdd->prepare('SELECT * FROM pompe_filtration WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			if (explode(".", $version)[0] == '1') {
								$data_pompe_filtration = array(
					'installe' => (int)$donnees['installe'],
					'etat' => (int)$donnees['etat'],
					'lecture_capteurs' => (int)$donnees['lecture_capteurs'],
					'date_consommation' => (string)$donnees['date_consommation'],
					'consommation_hp' => (float)$donnees['consommation_hp'],
					'consommation_hc' => (float)$donnees['consommation_hc'],
					'plage_1' => (string)$donnees['plage_1'],
					'plage_2' => (string)$donnees['plage_2'],
					'plage_3' => (string)$donnees['plage_3'],
					'plage_4' => (string)$donnees['plage_4']
				);
			} else {
				$data_pompe_filtration = array(
					'installe' => (int)$donnees['installe'],
					'etat' => (int)$donnees['etat'],
					'lecture_capteurs' => (int)$donnees['lecture_capteurs'],
					'date_consommation' => (string)$donnees['date_consommation'],
					'consommation_hp' => (float)$donnees['consommation_hp'],
					'consommation_hc' => (float)$donnees['consommation_hc'],
					'plage_1' => (string)$donnees['plage_1'],
					'plage_2' => (string)$donnees['plage_2'],
					'plage_3' => (string)$donnees['plage_3'],
					'plage_4' => (string)$donnees['plage_4'],
					'etat_hors_gel' => (int)$donnees['etat_hors_gel'],
					'enclenchement_hors_gel' => (int)$donnees['enclenchement_hors_gel'],
					'arret_hors_gel' => (int)$donnees['arret_hors_gel'],
					'frequence_hors_gel' => (int)$donnees['frequence_hors_gel']
				);
			}

			$req->closeCursor();


			// Filtre
			$req = $bdd->prepare('SELECT * FROM filtre WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			if (explode(".", $version)[0] == '1') {
				$data_filtre = array(
					'installe' => (int)$donnees['installe'],
					'date_dernier_lavage' => (string)$donnees['date_dernier_lavage'],
					'pression_apres_lavage' => (float)$donnees['pression_apres_lavage'],
					'pression_prochain_lavage' => (float)$donnees['pression_prochain_lavage'],
					'seuil_securite_surpression' => (float)$donnees['seuil_securite_surpression'],
					'seuil_haut_pression' => (float)$donnees['seuil_haut_pression'],
					'seuil_bas_pression' => (float)$donnees['seuil_bas_pression']
				);
			} else {
				$data_filtre = array(
					'installe' => (int)$donnees['installe'],
					'date_dernier_lavage' => (string)$donnees['date_dernier_lavage'],
					'pression_apres_lavage' => (float)$donnees['pression_apres_lavage'],
					'pression_prochain_lavage' => (float)$donnees['pression_prochain_lavage'],
					'seuil_rincage' => (int)$donnees['seuil_rincage'],
					'seuil_securite_surpression' => (float)$donnees['seuil_securite_surpression'],
					'seuil_haut_pression' => (float)$donnees['seuil_haut_pression'],
					'seuil_bas_pression' => (float)$donnees['seuil_bas_pression']
				);
			}

			$req->closeCursor();

			
			// Surpresseur
			$req = $bdd->prepare('SELECT * FROM surpresseur WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			$data_surpresseur = array(
				'installe' => (int)$donnees['installe'],
				'etat' => (int)$donnees['etat'],
				'date_consommation' => (string)$donnees['date_consommation'],
				'consommation_hp' => (float)$donnees['consommation_hp'],
				'consommation_hc' => (float)$donnees['consommation_hc'],
				'plage_1' => (string)$donnees['plage_1'],
				'plage_2' => (string)$donnees['plage_2'],
				'plage_3' => (string)$donnees['plage_3'],
				'plage_4' => (string)$donnees['plage_4']
			);

			$req->closeCursor();


			// Chauffage
			$req = $bdd->prepare('SELECT * FROM chauffage WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			if (explode(".", $version)[0] == '1') {
				$data_chauffage = array(
					'installe' => (int)$donnees['installe'],
					'etat' => (int)$donnees['etat'],
					'date_consommation' => (string)$donnees['date_consommation'],
					'consommation_hp' => (float)$donnees['consommation_hp'],
					'consommation_hc' => (float)$donnees['consommation_hc'],
					'gestion_temperature' => (int)$donnees['gestion_temperature'],
					'temperature_arret' => (int)$donnees['temperature_arret'],
					'temperature_encl' => (int)$donnees['temperature_encl'],
					'temperature_consigne' => (int)$donnees['temperature_consigne'],
					'plage_1' => (string)$donnees['plage_1'],
					'plage_2' => (string)$donnees['plage_2'],
					'plage_3' => (string)$donnees['plage_3'],
					'plage_4' => (string)$donnees['plage_4'],
					'type_chauffage' => (int)$donnees['type_chauffage'],
					'alarme_seuil_bas' => (int)$donnees['alarme_seuil_bas'],
					'alarme_seuil_haut' => (int)$donnees['alarme_seuil_haut']
				);
			} else {
				if ((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '6') && (explode(".", $version)[2] >= '1')) {
					$data_chauffage = array(
						'installe' => (int)$donnees['installe'],
						'etat' => (int)$donnees['etat'],
						'date_consommation' => (string)$donnees['date_consommation'],
						'consommation_hp' => (float)$donnees['consommation_hp'],
						'consommation_hc' => (float)$donnees['consommation_hc'],
						'gestion_temperature' => (int)$donnees['gestion_temperature'],
						'temperature_consigne' => (int)$donnees['temperature_consigne'],
						'gestion_reversible' => (int)$donnees['gestion_reversible'],
						'temperature_reversible' => (int)$donnees['temperature_reversible'],
						'type_chauffage' => (int)$donnees['type_chauffage'],
						'alarme_seuil_bas' => (int)$donnees['alarme_seuil_bas'],
						'alarme_seuil_haut' => (int)$donnees['alarme_seuil_haut']
					);
				} else {
					$data_chauffage = array(
						'installe' => (int)$donnees['installe'],
						'etat' => (int)$donnees['etat'],
						'date_consommation' => (string)$donnees['date_consommation'],
						'consommation_hp' => (float)$donnees['consommation_hp'],
						'consommation_hc' => (float)$donnees['consommation_hc'],
						'gestion_temperature' => (int)$donnees['gestion_temperature'],
						'temperature_arret' => (int)$donnees['temperature_arret'],
						'temperature_encl' => (int)$donnees['temperature_encl'],
						'temperature_consigne' => (int)$donnees['temperature_consigne'],
						'type_chauffage' => (int)$donnees['type_chauffage'],
						'alarme_seuil_bas' => (int)$donnees['alarme_seuil_bas'],
						'alarme_seuil_haut' => (int)$donnees['alarme_seuil_haut']
					);
				}
			}

			$req->closeCursor();


			// Lampes UV
			$req = $bdd->prepare('SELECT * FROM lampes_uv WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			$data_lampes_uv = array(
				'installe' => (int)$donnees['installe'],
				'etat' => (int)$donnees['etat'],
				'date_consommation' => (string)$donnees['date_consommation'],
				'consommation_hp' => (float)$donnees['consommation_hp'],
				'consommation_hc' => (float)$donnees['consommation_hc']
			);

			$req->closeCursor();


			// Ozonateur
			$req = $bdd->prepare('SELECT * FROM ozonateur WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			$data_ozonateur = array(
				'installe' => (int)$donnees['installe'],
				'etat' => (int)$donnees['etat'],
				'date_consommation' => (string)$donnees['date_consommation'],
				'consommation_hp' => (float)$donnees['consommation_hp'],
				'consommation_hc' => (float)$donnees['consommation_hc']
			);

			$req->closeCursor();


			// Electrolyseur
			$req = $bdd->prepare('SELECT * FROM electrolyseur WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			$data_electrolyseur = array(
				'installe' => (int)$donnees['installe'],
				'etat' => (int)$donnees['etat'],
				'date_consommation' => (string)$donnees['date_consommation'],
				'consommation_hp' => (float)$donnees['consommation_hp'],
				'consommation_hc' => (float)$donnees['consommation_hc']
			);

			$req->closeCursor();


			// Régulateur pH
			$req = $bdd->prepare('SELECT * FROM regulateur_ph WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			$data_reg_ph = array(
				'point_consigne' => (float)$donnees['point_consigne'],
				'hysteresis_plus' => (float)$donnees['hysteresis_plus'],
				'hysteresis_moins' => (float)$donnees['hysteresis_moins'],
				'alarme_seuil_bas' => (float)$donnees['alarme_seuil_bas'],
				'alarme_seuil_haut' => (float)$donnees['alarme_seuil_haut']
			);

			$req->closeCursor();


			// Régulateur pH-
			$req = $bdd->prepare('SELECT * FROM regulateur_ph_moins WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			if (((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '4')) || ((explode(".", $version)[0] > '2'))) {
				$data_ph_moins = array(
					'installe' => (int)$donnees['installe'],
					'etat' => (int)$donnees['etat'],
					'date_consommation' => (string)$donnees['date_consommation'],
					'volume' => (float)$donnees['volume'],
					'volume_restant' => (float)$donnees['volume_restant'],
					'consommation_jour' => (float)$donnees['consommation_jour'],
					'consommation_semaine' => (float)$donnees['consommation_semaine'],
					'consommation_mois' => (float)$donnees['consommation_mois'],
					'injection' => (int)$donnees['injection'],
					'duree_cycle' => (int)$donnees['duree_cycle'],
					'multiplicateur_diff' => (int)$donnees['multiplicateur_diff'],
					'duree_injection_minimum' => (string)$donnees['duree_injection_minimum'],
					'duree_injection' => (string)$donnees['duree_injection'],
					'temps_reponse' => (string)$donnees['temps_reponse'],
					'temps_injection_jour_max' => (int)$donnees['temps_injection_jour_max'],
					'temps_injection_jour_max_restant' => (int)$donnees['temps_injection_jour_max_restant']
				);
			} else {
				$data_ph_moins = array(
					'installe' => (int)$donnees['installe'],
					'etat' => (int)$donnees['etat'],
					'date_consommation' => (string)$donnees['date_consommation'],
					'volume' => (float)$donnees['volume'],
					'volume_restant' => (float)$donnees['volume_restant'],
					'consommation_jour' => (float)$donnees['consommation_jour'],
					'consommation_semaine' => (float)$donnees['consommation_semaine'],
					'consommation_mois' => (float)$donnees['consommation_mois'],
					'injection' => (int)$donnees['injection'],
					'duree_cycle' => (int)$donnees['duree_cycle'],
					'multiplicateur_diff' => (int)$donnees['multiplicateur_diff'],
					'duree_injection' => (string)$donnees['duree_injection'],
					'temps_reponse' => (string)$donnees['temps_reponse'],
					'temps_injection_jour_max' => (int)$donnees['temps_injection_jour_max'],
					'temps_injection_jour_max_restant' => (int)$donnees['temps_injection_jour_max_restant']
				);
			}

			$req->closeCursor();


			// Régulateur pH+
			$req = $bdd->prepare('SELECT * FROM regulateur_ph_plus WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			if (((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '4')) || ((explode(".", $version)[0] > '2'))) {
				$data_ph_plus = array(
					'installe' => (int)$donnees['installe'],
					'etat' => (int)$donnees['etat'],
					'date_consommation' => (string)$donnees['date_consommation'],
					'volume' => (float)$donnees['volume'],
					'volume_restant' => (float)$donnees['volume_restant'],
					'consommation_jour' => (float)$donnees['consommation_jour'],
					'consommation_semaine' => (float)$donnees['consommation_semaine'],
					'consommation_mois' => (float)$donnees['consommation_mois'],
					'injection' => (int)$donnees['injection'],
					'duree_cycle' => (int)$donnees['duree_cycle'],
					'multiplicateur_diff' => (int)$donnees['multiplicateur_diff'],
					'duree_injection_minimum' => (string)$donnees['duree_injection_minimum'],
					'duree_injection' => (string)$donnees['duree_injection'],
					'temps_reponse' => (string)$donnees['temps_reponse'],
					'temps_injection_jour_max' => (int)$donnees['temps_injection_jour_max'],
					'temps_injection_jour_max_restant' => (int)$donnees['temps_injection_jour_max_restant']
				);
			} else {
				$data_ph_plus = array(
					'installe' => (int)$donnees['installe'],
					'etat' => (int)$donnees['etat'],
					'date_consommation' => (string)$donnees['date_consommation'],
					'volume' => (float)$donnees['volume'],
					'volume_restant' => (float)$donnees['volume_restant'],
					'consommation_jour' => (float)$donnees['consommation_jour'],
					'consommation_semaine' => (float)$donnees['consommation_semaine'],
					'consommation_mois' => (float)$donnees['consommation_mois'],
					'injection' => (int)$donnees['injection'],
					'duree_cycle' => (int)$donnees['duree_cycle'],
					'multiplicateur_diff' => (int)$donnees['multiplicateur_diff'],
					'duree_injection' => (string)$donnees['duree_injection'],
					'temps_reponse' => (string)$donnees['temps_reponse'],
					'temps_injection_jour_max' => (int)$donnees['temps_injection_jour_max'],
					'temps_injection_jour_max_restant' => (int)$donnees['temps_injection_jour_max_restant']
				);
			}

			$req->closeCursor();


			// Régulateur ORP
			$req = $bdd->prepare('SELECT * FROM regulateur_orp WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			if (((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '4')) || ((explode(".", $version)[0] > '2'))) {
				$data_regulateur_orp = array(
					'installe' => (int)$donnees['installe'],
					'point_consigne_orp' => (int)$donnees['point_consigne_orp'],
					'hysteresis_orp' => (int)$donnees['hysteresis_orp'],
					'point_consigne_ampero' => (float)$donnees['point_consigne_ampero'],
					'hysteresis_ampero' => (float)$donnees['hysteresis_ampero'],
					'chlore_libre_actif' => (float)$donnees['chlore_libre_actif'],
					'etat' => (int)$donnees['etat'],
					'date_consommation' => (string)$donnees['date_consommation'],
					'volume' => (float)$donnees['volume'],
					'volume_restant' => (float)$donnees['volume_restant'],
					'consommation_jour' => (float)$donnees['consommation_jour'],
					'consommation_semaine' => (float)$donnees['consommation_semaine'],
					'consommation_mois' => (float)$donnees['consommation_mois'],
					'injection' => (int)$donnees['injection'],
					'duree_cycle' => (int)$donnees['duree_cycle'],
					'multiplicateur_diff' => (int)$donnees['multiplicateur_diff'],
					'duree_injection_minimum' => (string)$donnees['duree_injection_minimum'],
					'duree_injection' => (string)$donnees['duree_injection'],
					'temps_reponse' => (string)$donnees['temps_reponse'],
					'temps_injection_jour_max' => (int)$donnees['temps_injection_jour_max'],
					'temps_injection_jour_max_restant' => (int)$donnees['temps_injection_jour_max_restant'],
					'surchloration' => (int)$donnees['surchloration'],
					'frequence' => (string)$donnees['frequence'],
					'mv_ajoute' => (int)$donnees['mv_ajoute'],
					'prochaine_surchloration' => (int)$donnees['prochaine_surchloration'],
					'alarme_seuil_bas_ampero' => (float)$donnees['alarme_seuil_bas_ampero'],
					'alarme_seuil_haut_ampero' => (float)$donnees['alarme_seuil_haut_ampero'],
					'alarme_seuil_bas_orp' => (int)$donnees['alarme_seuil_bas_orp'],
					'alarme_seuil_haut_orp' => (int)$donnees['alarme_seuil_haut_orp']
				);
			} else {
				$data_regulateur_orp = array(
					'installe' => (int)$donnees['installe'],
					'point_consigne_orp' => (int)$donnees['point_consigne_orp'],
					'hysteresis_orp' => (int)$donnees['hysteresis_orp'],
					'point_consigne_ampero' => (float)$donnees['point_consigne_ampero'],
					'hysteresis_ampero' => (float)$donnees['hysteresis_ampero'],
					'chlore_libre_actif' => (float)$donnees['chlore_libre_actif'],
					'etat' => (int)$donnees['etat'],
					'date_consommation' => (string)$donnees['date_consommation'],
					'volume' => (float)$donnees['volume'],
					'volume_restant' => (float)$donnees['volume_restant'],
					'consommation_jour' => (float)$donnees['consommation_jour'],
					'consommation_semaine' => (float)$donnees['consommation_semaine'],
					'consommation_mois' => (float)$donnees['consommation_mois'],
					'injection' => (int)$donnees['injection'],
					'duree_cycle' => (int)$donnees['duree_cycle'],
					'multiplicateur_diff' => (int)$donnees['multiplicateur_diff'],
					'duree_injection' => (string)$donnees['duree_injection'],
					'temps_reponse' => (string)$donnees['temps_reponse'],
					'temps_injection_jour_max' => (int)$donnees['temps_injection_jour_max'],
					'temps_injection_jour_max_restant' => (int)$donnees['temps_injection_jour_max_restant'],
					'surchloration' => (int)$donnees['surchloration'],
					'frequence' => (string)$donnees['frequence'],
					'mv_ajoute' => (int)$donnees['mv_ajoute'],
					'prochaine_surchloration' => (int)$donnees['prochaine_surchloration'],
					'alarme_seuil_bas_ampero' => (float)$donnees['alarme_seuil_bas_ampero'],
					'alarme_seuil_haut_ampero' => (float)$donnees['alarme_seuil_haut_ampero'],
					'alarme_seuil_bas_orp' => (int)$donnees['alarme_seuil_bas_orp'],
					'alarme_seuil_haut_orp' => (int)$donnees['alarme_seuil_haut_orp']
				);
			}

			$req->closeCursor();


			// Algicide
			$req = $bdd->prepare('SELECT * FROM algicide WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$donnees = $req->fetch();

			$data_algicide = array(
				'installe' => (int)$donnees['installe'],
				'etat' => (int)$donnees['etat'],
				'date_consommation' => (string)$donnees['date_consommation'],
				'volume' => (float)$donnees['volume'],
				'volume_restant' => (float)$donnees['volume_restant'],
				'injection' => (int)$donnees['injection'],
				'active' => (int)$donnees['active'],
				'frequence' => (string)$donnees['frequence'],
				'pendant' => (int)$donnees['pendant'],
				'prochain' => (int)$donnees['prochain'],
				'temps_restant' => (int)$donnees['temps_restant']
			);

			$req->closeCursor();


			// Fontaine
			if ((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '6') && (explode(".", $version)[2] >= '2')) {
				$req = $bdd->prepare('SELECT * FROM fontaine WHERE id_systeme = :id_systeme');
				$req->execute(array(
					'id_systeme' => $id
					));

				$donnees = $req->fetch();

				$data_fontaine = array(
					'installe' => (int)$donnees['installe'],
					'etat' => (int)$donnees['etat'],
					'plage_1' => (string)$donnees['plage_1'],
					'plage_2' => (string)$donnees['plage_2'],
					'plage_3' => (string)$donnees['plage_3'],
					'plage_4' => (string)$donnees['plage_4']
				);

				$req->closeCursor();
			}


			// Capteurs
			$req = $bdd->prepare('SELECT * FROM capteurs WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));

			$data_temp_bassin = array();
			$data_temp_interne = array();
			$data_humidite_interne = array();
			$data_pression_atm_interne = array();
			$data_temp_externe = array();
			$data_humidite_externe = array();
			$data_pression_atm_externe = array();
			$data_ph = array();
			$data_orp = array();
			$data_pression = array();
			$data_ampero_DPD1 = array();
			$data_ampero_DPD4 = array();
			while ($donnees = $req->fetch())
			{
				if (explode(".", $version)[0] == '1') {
					$data = array(
						'installe' => (int)$donnees['installe'],
						'etat' => (string)$donnees['etat'],
						'valeur' => (float)$donnees['valeur']
					);
				} else {
					$data = array(
						'installe' => (int)$donnees['installe'],
						'etat' => (string)$donnees['etat'],
						'valeur' => (float)$donnees['valeur'],
						'autre' => (string)$donnees['autre'],
						'etalonnage' => (int)$donnees['etalonnage'],
						'valeur_etalonnage' => (float)$donnees['valeur_etalonnage']
					);
				}

				if ((string)$donnees['type'] == 'Température bassin')
				{
					$data_temp_bassin = $data;
				}
				elseif ((string)$donnees['type'] == 'Température interne')
				{
					$data_temp_interne = $data;
				}
				elseif ((string)$donnees['type'] == 'Humidité interne')
				{
					$data_humidite_interne = $data;
				}
				elseif ((string)$donnees['type'] == 'Pression atmosphérique interne')
				{
					$data_pression_atm_interne = $data;
				}
				elseif ((string)$donnees['type'] == 'Température externe')
				{
					$data_temp_externe = $data;
				}
				elseif ((string)$donnees['type'] == 'Humidité externe')
				{
					$data_humidite_externe = $data;
				}
				elseif ((string)$donnees['type'] == 'Pression atmosphérique externe')
				{
					$data_pression_atm_externe = $data;
				}
				elseif ((string)$donnees['type'] == 'pH')
				{
					$data_ph = $data;
				}
				elseif ((string)$donnees['type'] == 'ORP')
				{
					$data_orp = $data;
				}
				elseif ((string)$donnees['type'] == 'Pression')
				{
					$data_pression = $data;
				}
				elseif ((string)$donnees['type'] == 'Ampéro')
				{
					$data_ampero_DPD1 = $data;
				}
				elseif ((string)$donnees['type'] == 'Ampéro DPD4')
				{
					$data_ampero_DPD4 = $data;
				}
			}

			if ((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '6') && (explode(".", $version)[2] >= '1')) {
				$data_capteurs = array(
					'Température bassin' => $data_temp_bassin,
					'Température interne' => $data_temp_interne,
					'Humidité interne' => $data_humidite_interne,
					'Pression atmosphérique interne' => $data_pression_atm_interne,
					'Température externe' => $data_temp_externe,
					'Humidité externe' => $data_humidite_externe,
					'Pression atmosphérique externe' => $data_pression_atm_externe,
					'pH' => $data_ph,
					'ORP' => $data_orp,
					'Pression' => $data_pression,
					'Ampéro' => $data_ampero_DPD1,
					'Ampéro DPD4' => $data_ampero_DPD4
				);
			} else {
				$data_capteurs = array(
					'Température bassin' => $data_temp_bassin,
					'Température interne' => $data_temp_interne,
					'Humidité interne' => $data_humidite_interne,
					'Pression atmosphérique interne' => $data_pression_atm_interne,
					'Température externe' => $data_temp_externe,
					'Humidité externe' => $data_humidite_externe,
					'Pression atmosphérique externe' => $data_pression_atm_externe,
					'pH' => $data_ph,
					'ORP' => $data_orp,
					'Pression' => $data_pression,
					'Ampéro' => $data_ampero_DPD1
				);
			}

			$req->closeCursor();


			// Format d'envoi
			if ((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '6') && (explode(".", $version)[2] >= '2')) {
				$output = array(
					'Système' => $data_systeme,
					'Events' => $data_events,
					'Automatisation' => $data_automatisation,
					'Horlogerie' => $data_horlogerie,
					'Bassin' => $data_bassin,
					'Eclairage' => $data_eclairage,
					'Pompe filtration' => $data_pompe_filtration,
					'Filtre' => $data_filtre,
					'Surpresseur' => $data_surpresseur,
					'Chauffage' => $data_chauffage,
					'Lampes UV' => $data_lampes_uv,
					'Ozonateur' => $data_ozonateur,
					'Electrolyseur' => $data_electrolyseur,
					'Régulateur pH' => $data_reg_ph,
					'Régulateur pH-' => $data_ph_moins,
					'Régulateur pH+' => $data_ph_plus,
					'Régulateur ORP' => $data_regulateur_orp,
					'Algicide' => $data_algicide,
					'Fontaine' => $data_fontaine,
					'Capteurs' => $data_capteurs
				);
			} else {
				$output = array(
					'Système' => $data_systeme,
					'Events' => $data_events,
					'Automatisation' => $data_automatisation,
					'Horlogerie' => $data_horlogerie,
					'Bassin' => $data_bassin,
					'Eclairage' => $data_eclairage,
					'Pompe filtration' => $data_pompe_filtration,
					'Filtre' => $data_filtre,
					'Surpresseur' => $data_surpresseur,
					'Chauffage' => $data_chauffage,
					'Lampes UV' => $data_lampes_uv,
					'Ozonateur' => $data_ozonateur,
					'Electrolyseur' => $data_electrolyseur,
					'Régulateur pH' => $data_reg_ph,
					'Régulateur pH-' => $data_ph_moins,
					'Régulateur pH+' => $data_ph_plus,
					'Régulateur ORP' => $data_regulateur_orp,
					'Algicide' => $data_algicide,
					'Capteurs' => $data_capteurs
				);
			}

			echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		} else {
			echo '<';


			// Système
			echo (string)$donnees['alive'];
			echo ';';
			echo (int)$donnees['block'];
			echo ';';
			echo (int)$donnees['background'];
			echo ';';
			$req->closeCursor();


			// Horlogerie
			$req = $bdd->prepare('SELECT * FROM horlogerie WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));
			$donnees = $req->fetch();
			echo (string)$donnees['index_gmt'];
			echo ';';
			$req->closeCursor();


			// Bassin
			$req = $bdd->prepare('SELECT * FROM bassin WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));
			$donnees = $req->fetch();
			echo (int)$donnees['volume'];
			echo ';';
			if ((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '6') && (explode(".", $version)[2] >= '1')) {
				echo (int)$donnees['temporisation_demarrage'];
				echo ';';
			}
			echo (string)$donnees['type_refoulement'];
			echo ';';
			echo (string)$donnees['type_regulation'];
			echo ';';
			echo (int)$donnees['temps_securite_injection'];
			echo ';';
			echo (float)$donnees['hyst_injection_ph'];
			echo ';';
			echo (int)$donnees['hyst_injection_orp'];
			echo ';';
			echo (float)$donnees['hyst_injection_ampero'];
			echo ';';
			echo (int)$donnees['etat_regulations'];
			echo ';';
			$req->closeCursor();


			// Pompe filtration
			$req = $bdd->prepare('SELECT * FROM pompe_filtration WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));
			$donnees = $req->fetch();
			echo (int)$donnees['installe'];
			echo ';';
			echo (int)$donnees['etat'];
			echo ';';
			echo (int)$donnees['lecture_capteurs'];
			echo ';';
			echo (string)$donnees['plage_1'];
			echo ';';
			echo (string)$donnees['plage_2'];
			echo ';';
			echo (string)$donnees['plage_3'];
			echo ';';
			echo (string)$donnees['plage_4'];
			echo ';';
			echo (int)$donnees['etat_hors_gel'];
			echo ';';
			echo (int)$donnees['enclenchement_hors_gel'];
			echo ';';
			echo (int)$donnees['arret_hors_gel'];
			echo ';';
			echo (int)$donnees['frequence_hors_gel'];
			echo ';';
			$req->closeCursor();


			// Filtre
			$req = $bdd->prepare('SELECT * FROM filtre WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));
			$donnees = $req->fetch();
			echo (int)$donnees['installe'];
			echo ';';
			echo (string)$donnees['date_dernier_lavage'];
			echo ';';
			echo (float)$donnees['pression_apres_lavage'];
			echo ';';
			echo (float)$donnees['pression_prochain_lavage'];
			echo ';';
			echo (int)$donnees['seuil_rincage'];
			echo ';';
			echo (float)$donnees['seuil_securite_surpression'];
			echo ';';
			echo (float)$donnees['seuil_haut_pression'];
			echo ';';
			echo (float)$donnees['seuil_bas_pression'];
			echo ';';
			$req->closeCursor();


			// Chauffage
			$req = $bdd->prepare('SELECT * FROM chauffage WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));
			$donnees = $req->fetch();
			echo (int)$donnees['installe'];
			echo ';';
			echo (int)$donnees['etat'];
			echo ';';
			echo (int)$donnees['gestion_temperature'];
			echo ';';
			echo (int)$donnees['temperature_consigne'];
			echo ';';
			echo (int)$donnees['gestion_reversible'];
			echo ';';
			echo (int)$donnees['temperature_reversible'];
			echo ';';
			echo (int)$donnees['type_chauffage'];
			echo ';';
			echo (int)$donnees['alarme_seuil_bas'];
			echo ';';
			echo (int)$donnees['alarme_seuil_haut'];
			echo ';';
			$req->closeCursor();


			if ((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '6') && (explode(".", $version)[2] >= '1')) {
				// Eclairage
				$req = $bdd->prepare('SELECT * FROM eclairage WHERE id_systeme = :id_systeme');
				$req->execute(array(
					'id_systeme' => $id
					));
				$donnees = $req->fetch();
				echo (int)$donnees['installe'];
				echo ';';
				echo (int)$donnees['etat'];
				echo ';';
				echo (string)$donnees['plage_1'];
				echo ';';
				echo (string)$donnees['plage_2'];
				echo ';';
				echo (string)$donnees['plage_3'];
				echo ';';
				echo (string)$donnees['plage_4'];
				echo ';';
				$req->closeCursor();
			}

			// Régulateur pH
			$req = $bdd->prepare('SELECT * FROM regulateur_ph WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));
			$donnees = $req->fetch();
			echo (float)$donnees['point_consigne'];
			echo ';';
			echo (float)$donnees['hysteresis_plus'];
			echo ';';
			echo (float)$donnees['hysteresis_moins'];
			echo ';';
			echo (float)$donnees['alarme_seuil_bas'];
			echo ';';
			echo (float)$donnees['alarme_seuil_haut'];
			echo ';';
			$req->closeCursor();


			// Régulateur pH-
			$req = $bdd->prepare('SELECT * FROM regulateur_ph_moins WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));
			$donnees = $req->fetch();
			echo (int)$donnees['installe'];
			echo ';';
			echo (int)$donnees['etat'];
			echo ';';
			echo (string)$donnees['date_consommation'];
			echo ';';
			echo (float)$donnees['volume'];
			echo ';';
			echo (float)$donnees['volume_restant'];
			echo ';';
			echo (float)$donnees['consommation_jour'];
			echo ';';
			echo (float)$donnees['consommation_semaine'];
			echo ';';
			echo (float)$donnees['consommation_mois'];
			echo ';';
			echo (int)$donnees['injection'];
			echo ';';
			echo (int)$donnees['duree_cycle'];
			echo ';';
			echo (int)$donnees['multiplicateur_diff'];
			echo ';';
			echo (string)$donnees['duree_injection_minimum'];
			echo ';';
			echo (string)$donnees['duree_injection'];
			echo ';';
			echo (string)$donnees['temps_reponse'];
			echo ';';
			echo (int)$donnees['temps_injection_jour_max'];
			echo ';';
			echo (int)$donnees['temps_injection_jour_max_restant'];
			echo ';';
			$req->closeCursor();


			// Régulateur pH+
			$req = $bdd->prepare('SELECT * FROM regulateur_ph_plus WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));
			$donnees = $req->fetch();
			echo (int)$donnees['installe'];
			echo ';';
			echo (int)$donnees['etat'];
			echo ';';
			echo (string)$donnees['date_consommation'];
			echo ';';
			echo (float)$donnees['volume'];
			echo ';';
			echo (float)$donnees['volume_restant'];
			echo ';';
			echo (float)$donnees['consommation_jour'];
			echo ';';
			echo (float)$donnees['consommation_semaine'];
			echo ';';
			echo (float)$donnees['consommation_mois'];
			echo ';';
			echo (int)$donnees['injection'];
			echo ';';
			echo (int)$donnees['duree_cycle'];
			echo ';';
			echo (int)$donnees['multiplicateur_diff'];
			echo ';';
			echo (string)$donnees['duree_injection_minimum'];
			echo ';';
			echo (string)$donnees['duree_injection'];
			echo ';';
			echo (string)$donnees['temps_reponse'];
			echo ';';
			echo (int)$donnees['temps_injection_jour_max'];
			echo ';';
			echo (int)$donnees['temps_injection_jour_max_restant'];
			echo ';';
			$req->closeCursor();


			// Régulateur ORP
			$req = $bdd->prepare('SELECT * FROM regulateur_orp WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));
			$donnees = $req->fetch();
			echo (int)$donnees['installe'];
			echo ';';
			echo (int)$donnees['point_consigne_orp'];
			echo ';';
			echo (int)$donnees['hysteresis_orp'];
			echo ';';
			echo (float)$donnees['point_consigne_ampero'];
			echo ';';
			echo (float)$donnees['hysteresis_ampero'];
			echo ';';
			echo (float)$donnees['chlore_libre_actif'];
			echo ';';
			echo (int)$donnees['etat'];
			echo ';';
			echo (string)$donnees['date_consommation'];
			echo ';';
			echo (float)$donnees['volume'];
			echo ';';
			echo (float)$donnees['volume_restant'];
			echo ';';
			echo (float)$donnees['consommation_jour'];
			echo ';';
			echo (float)$donnees['consommation_semaine'];
			echo ';';
			echo (float)$donnees['consommation_mois'];
			echo ';';
			echo (int)$donnees['injection'];
			echo ';';
			echo (int)$donnees['duree_cycle'];
			echo ';';
			echo (int)$donnees['multiplicateur_diff'];
			echo ';';
			echo (string)$donnees['duree_injection_minimum'];
			echo ';';
			echo (string)$donnees['duree_injection'];
			echo ';';
			echo (string)$donnees['temps_reponse'];
			echo ';';
			echo (int)$donnees['temps_injection_jour_max'];
			echo ';';
			echo (int)$donnees['temps_injection_jour_max_restant'];
			echo ';';
			echo (float)$donnees['alarme_seuil_bas_ampero'];
			echo ';';
			echo (float)$donnees['alarme_seuil_haut_ampero'];
			echo ';';
			echo (int)$donnees['alarme_seuil_bas_orp'];
			echo ';';
			echo (int)$donnees['alarme_seuil_haut_orp'];
			echo ';';
			echo (int)$donnees['surchloration'];
			echo ';';
			echo (string)$donnees['frequence'];
			echo ';';
			echo (int)$donnees['mv_ajoute'];
			echo ';';
			echo (int)$donnees['prochaine_surchloration'];
			echo ';';
			$req->closeCursor();


			// Algicide
			$req = $bdd->prepare('SELECT * FROM algicide WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));
			$donnees = $req->fetch();
			echo (int)$donnees['installe'];
			echo ';';
			echo (int)$donnees['etat'];
			echo ';';
			echo (string)$donnees['date_consommation'];
			echo ';';
			echo (float)$donnees['volume'];
			echo ';';
			echo (float)$donnees['volume_restant'];
			echo ';';
			echo (int)$donnees['injection'];
			echo ';';
			echo (string)$donnees['frequence'];
			echo ';';
			echo (int)$donnees['pendant'];
			echo ';';
			echo (int)$donnees['prochain'];
			echo ';';
			echo (int)$donnees['temps_restant'];
			echo ';';
			$req->closeCursor();


			// Automatisation
			$req = $bdd->prepare('SELECT * FROM automatisation WHERE id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $id
				));
			$donnees = $req->fetch();
			echo (int)$donnees['donnees_equipement'];
			echo ';';
			echo (int)$donnees['modif_plage_auto'];
			echo ';';
			echo (int)$donnees['plages_auto'];
			echo ';';
			echo (string)$donnees['debut_plage_auto'];
			echo ';';
			echo (string)$donnees['temps_filtration_jour'];
			echo ';';
			echo (int)$donnees['asservissement_ph_plus'];
			echo ';';
			echo (int)$donnees['asservissement_ph_moins'];
			echo ';';
			echo (int)$donnees['asservissement_orp'];
			echo ';';
			echo (int)$donnees['consigne_orp_auto'];
			if ((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '6') && (explode(".", $version)[2] >= '1')) {
				echo ';';
				echo (int)$donnees['capteur_niveau_eau'];
			}
			$req->closeCursor();


			// Capteurs
			$req = $bdd->prepare('SELECT * FROM capteurs WHERE id_systeme = :id_systeme ORDER BY id ASC');
			$req->execute(array(
				'id_systeme' => $id
				));
			while ($donnees = $req->fetch())
			{
				if ((string)$donnees['type'] == 'Température bassin'
					|| (string)$donnees['type'] == 'pH'
					|| (string)$donnees['type'] == 'ORP'
					|| (string)$donnees['type'] == 'Pression'
					|| (string)$donnees['type'] == 'Ampéro') {
					echo ';';
					echo (int)$donnees['installe'];
					echo ';';
					echo (string)$donnees['etat'];
					echo ';';
					echo (float)$donnees['valeur'];
					echo ';';
					echo (string)$donnees['autre'];
					echo ';';
					echo (int)$donnees['etalonnage'];
					echo ';';
					echo (float)$donnees['valeur_etalonnage'];
				}
			}
			$req->closeCursor();

			echo '>';
		}
	}
}
?>