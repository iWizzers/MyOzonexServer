<?php
include("bdd_connect.php");


$API_KEY='AIzaSyCxVtrpaAk7ZQljPxI_tGHuSeOPcQNlzb8';


function get_coordinates_from_google_api($address) {
    global $API_KEY;
    $prepAddr = str_replace(' ','+',$address);
	$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key='.$API_KEY);
	$output= json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
	return array($latitude, $longitude);
}


function get_datetime_from_google_api($coordinates) {
    global $API_KEY;
	$time = time();
    $url = 'https://maps.googleapis.com/maps/api/timezone/json?location='.$coordinates[0].','.$coordinates[1].'&timestamp='.$time.'&key='.$API_KEY;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$responseJson = curl_exec($ch);
	curl_close($ch);
	 
	$response = json_decode($responseJson);
	$timezone = $response->timeZoneId;
	$date = new DateTime("now");

	if (!empty($timezone)) {
		$date->setTimezone(new DateTimeZone($timezone));
	}
	
	return $date->format('d-m-Y H:i:s');
}


function get_coordinates_from_address($address) {
    $key = '0t7AdxmKbrlWocm0Kvb4m6jtxGKPaICz'; // FREE : 15000/mois = 0€
    $geocode = file_get_contents('https://www.mapquestapi.com/geocoding/v1/address?key=' . $key . '&maxResults=1&location=' . urlencode($address) . '&thumbMaps=false');
    $output = json_decode($geocode);
    $latitude = $output->results[0]->locations[0]->latLng->lat;
    $longitude = $output->results[0]->locations[0]->latLng->lng;
    return array($latitude, $longitude);
}


function get_datetime_from_coordinates($coordinates, $country_code = '') {
    $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code)
                                    : DateTimeZone::listIdentifiers();
    $time_zone = '';

    if($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {
        $tz_distance = 0;

        //only one identifier?
        if (count($timezone_ids) == 1) {
            $time_zone = $timezone_ids[0];
        } else {
            foreach($timezone_ids as $timezone_id) {
                $timezone = new DateTimeZone($timezone_id);
                $location = $timezone->getLocation();
                $tz_lat   = $location['latitude'];
                $tz_long  = $location['longitude'];

                $theta    = $coordinates[1] - $tz_long;
                $distance = (sin(deg2rad($coordinates[0])) * sin(deg2rad($tz_lat))) 
                + (cos(deg2rad($coordinates[0])) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                $distance = acos($distance);
                $distance = abs(rad2deg($distance));

                if (!$time_zone || $tz_distance > $distance) {
                    $time_zone   = $timezone_id;
                    $tz_distance = $distance;
                }
            }
        }
    }

    return new DateTime("now", new DateTimeZone($time_zone));
}

function get_random_int($min, $max) {
    return rand($min, $max);
}

function create_new_device($id, $password) {
    global $bdd;

    // Hachage du mot de passe
    $pass_hache = password_hash($password, PASSWORD_DEFAULT);

    $date_heure = explode("-", '01/01/2020-00:00');
    $date = date_format(date_create_from_format('d/m/Y', $date_heure[0]), 'd/m/Y');
    $heure = date_format(date_create_from_format('H:i', $date_heure[1]), 'H:i');

    // Sélection du piscinier
    $req = $bdd->prepare('SELECT nom FROM pisciniers ORDER BY id LIMIT 1');
    $req->execute();
    $result = $req->fetch();
    $piscinier = (string)$result['nom'];

    // Création du nouvel utilisateur
    $req = $bdd->prepare('INSERT INTO login(id_systeme, password, alive, piscinier) VALUES(:id_systeme, :password, :alive, :piscinier)');
    $req->execute(array(
        'id_systeme' => $id,
        'password' => $pass_hache,
        'alive' => '01/01/2020-00:00',
        'piscinier' => $piscinier
    ));

    // Récupération de l'ID du nouvel utilisateur
    $req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
    $req->execute(array(
        'id_systeme' => $id));
    $result = $req->fetch();

    // Création premier evenement
    $req = $bdd->prepare('INSERT INTO events (id_systeme, texte, couleur, dateheure) VALUES(:id_systeme, :texte, :couleur, :dateheure)');
    $req->execute(array(
        'texte' => "Création sur le serveur",
        'couleur' => 0,
        'dateheure' => $date . '-' . $heure,
        'id_systeme' => (int)$result['id']
        ));

    // Création de la pompe de filtration
    $req = $bdd->prepare('INSERT INTO automatisation(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création de la pompe de filtration
    $req = $bdd->prepare('INSERT INTO pompe_filtration(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création du filtre
    $req = $bdd->prepare('INSERT INTO filtre(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création du surpresseur
    $req = $bdd->prepare('INSERT INTO surpresseur(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création du chauffage
    $req = $bdd->prepare('INSERT INTO chauffage(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création de l'ozonateur
    $req = $bdd->prepare('INSERT INTO ozonateur(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création des lampes UV
    $req = $bdd->prepare('INSERT INTO lampes_uv(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création de l'électrolyseur
    $req = $bdd->prepare('INSERT INTO electrolyseur(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création du régulateur de pH
    $req = $bdd->prepare('INSERT INTO regulateur_ph(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création du régulateur de pH+
    $req = $bdd->prepare('INSERT INTO regulateur_ph_plus(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création du régulateur de pH-
    $req = $bdd->prepare('INSERT INTO regulateur_ph_moins(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création du régulateur ORP
    $req = $bdd->prepare('INSERT INTO regulateur_orp(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création de l'algicide
    $req = $bdd->prepare('INSERT INTO algicide(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création de l'éclairage
    $req = $bdd->prepare('INSERT INTO eclairage(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création du bassin
    $req = $bdd->prepare('INSERT INTO bassin(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création de la fontaine
    $req = $bdd->prepare('INSERT INTO fontaine(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création de l'horlogerie
    $req = $bdd->prepare('INSERT INTO horlogerie(id_systeme) VALUES(:id_systeme)');
    $req->execute(array(
        'id_systeme' => (int)$result['id']
    ));

    // Création des capteurs
    //      Température du bassin
    $req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type, installe) VALUES(:id_systeme, :type, :installe)');
    $req->execute(array(
        'id_systeme' => (int)$result['id'],
        'type' => "Température bassin",
        'installe' => 1
    ));

    //      Température interne
    $req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type, installe) VALUES(:id_systeme, :type, :installe)');
    $req->execute(array(
        'id_systeme' => (int)$result['id'],
        'type' => "Température interne",
        'installe' => 0
    ));

    //      Humidité interne
    $req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type, installe) VALUES(:id_systeme, :type, :installe)');
    $req->execute(array(
        'id_systeme' => (int)$result['id'],
        'type' => "Humidité interne",
        'installe' => 0
    ));

    //      Pression atmosphérique interne
    $req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type, installe) VALUES(:id_systeme, :type, :installe)');
    $req->execute(array(
        'id_systeme' => (int)$result['id'],
        'type' => "Pression atmosphérique interne",
        'installe' => 0
    ));

    //      Température externe
    $req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type, installe) VALUES(:id_systeme, :type, :installe)');
    $req->execute(array(
        'id_systeme' => (int)$result['id'],
        'type' => "Température externe",
        'installe' => 0
    ));

    //      Humidité externe
    $req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type, installe) VALUES(:id_systeme, :type, :installe)');
    $req->execute(array(
        'id_systeme' => (int)$result['id'],
        'type' => "Humidité externe",
        'installe' => 0
    ));

    //      Pression atmosphérique externe
    $req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type, installe) VALUES(:id_systeme, :type, :installe)');
    $req->execute(array(
        'id_systeme' => (int)$result['id'],
        'type' => "Pression atmosphérique externe",
        'installe' => 0
    ));

    //      pH
    $req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type, installe) VALUES(:id_systeme, :type, :installe)');
    $req->execute(array(
        'id_systeme' => (int)$result['id'],
        'type' => "pH",
        'installe' => 1
    ));

    //      ORP
    $req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type, installe) VALUES(:id_systeme, :type, :installe)');
    $req->execute(array(
        'id_systeme' => (int)$result['id'],
        'type' => "ORP",
        'installe' => 1
    ));

    //      Pression
    $req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type, installe) VALUES(:id_systeme, :type, :installe)');
    $req->execute(array(
        'id_systeme' => (int)$result['id'],
        'type' => "Pression",
        'installe' => 0
    ));

    //      Ampéro (DPD1)
    $req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type, installe) VALUES(:id_systeme, :type, :installe)');
    $req->execute(array(
        'id_systeme' => (int)$result['id'],
        'type' => "Ampéro",
        'installe' => 0
    ));

    //      Ampéro (DPD4)
    $req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type, installe) VALUES(:id_systeme, :type, :installe)');
    $req->execute(array(
        'id_systeme' => (int)$result['id'],
        'type' => "Ampéro DPD4",
        'installe' => 0
    ));
}
?>