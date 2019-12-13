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

	if ($id != null) {
		// Système
		$data_systeme = array(
			'alive' => (string)$donnees['alive'],
			'blocage' => (int)$donnees['block'],
			'background' => (int)$donnees['background']
		);

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

		$req->closeCursor();


		// Filtre
		$req = $bdd->prepare('SELECT * FROM filtre WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => $id
			));

		$donnees = $req->fetch();

		$data_filtre = array(
			'installe' => (int)$donnees['installe'],
			'date_dernier_lavage' => (string)$donnees['date_dernier_lavage'],
			'pression_apres_lavage' => (float)$donnees['pression_apres_lavage'],
			'pression_prochain_lavage' => (float)$donnees['pression_prochain_lavage'],
			'seuil_securite_surpression' => (float)$donnees['seuil_securite_surpression'],
			'seuil_haut_pression' => (float)$donnees['seuil_haut_pression'],
			'seuil_bas_pression' => (float)$donnees['seuil_bas_pression']
		);

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
			'type_chauffage' => (int)$donnees['type_chauffage']
		);

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
			'hysteresis_moins' => (float)$donnees['hysteresis_moins']
		);

		$req->closeCursor();


		// Régulateur pH-
		$req = $bdd->prepare('SELECT * FROM regulateur_ph_moins WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => $id
			));

		$donnees = $req->fetch();

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

		$req->closeCursor();


		// Régulateur pH+
		$req = $bdd->prepare('SELECT * FROM regulateur_ph_plus WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => $id
			));

		$donnees = $req->fetch();

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

		$req->closeCursor();


		// Régulateur ORP
		$req = $bdd->prepare('SELECT * FROM regulateur_orp WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => $id
			));

		$donnees = $req->fetch();

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
			'prochaine_surchloration' => (int)$donnees['prochaine_surchloration']
		);

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
		$data_ampero = array();
		while ($donnees = $req->fetch())
		{
			$data = array(
				'installe' => (int)$donnees['installe'],
				'etat' => (string)$donnees['etat'],
				'valeur' => (float)$donnees['valeur']
			);

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
				$data_ampero = $data;
			}
		}

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
			'Ampéro' => $data_ampero
		);

		$req->closeCursor();


		// Format d'envoi
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

		echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	}
}
?>