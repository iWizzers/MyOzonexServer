<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme']) AND isset($_GET['password']) AND isset($_GET['alive'])) {
	// Vérifie si la base de données de l'utilisateur existe
	$req = $bdd->prepare('SELECT EXISTS (SELECT * FROM login WHERE id_systeme = :id_systeme) AS login_exists');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if (!$result['login_exists']) {
		// Hachage du mot de passe
		$pass_hache = password_hash($_GET['password'], PASSWORD_DEFAULT);

		// Création du nouvel utilisateur
		$req = $bdd->prepare('INSERT INTO login(id_systeme, password, alive) VALUES(:id_systeme, :password, :alive)');
		$req->execute(array(
			'id_systeme' => (string)$_GET['id_systeme'],
			'password' => $pass_hache,
			'alive' => (string)$_GET['alive']
		));

		// Récupération de l'ID du nouvel utilisateur
		$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (string)$_GET['id_systeme']));
		$result = $req->fetch();

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

		// Création de l'horlogerie
		$req = $bdd->prepare('INSERT INTO horlogerie(id_systeme) VALUES(:id_systeme)');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
		));

		// Création des capteurs
		//		Température du bassin
		$req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type) VALUES(:id_systeme, :type)');
		$req->execute(array(
			'id_systeme' => (int)$result['id'],
			'type' => "Température bassin"
		));

		//		Température interne
		$req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type) VALUES(:id_systeme, :type)');
		$req->execute(array(
			'id_systeme' => (int)$result['id'],
			'type' => "Température interne"
		));

		//		Humidité interne
		$req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type) VALUES(:id_systeme, :type)');
		$req->execute(array(
			'id_systeme' => (int)$result['id'],
			'type' => "Humidité interne"
		));

		//		Pression atmosphérique interne
		$req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type) VALUES(:id_systeme, :type)');
		$req->execute(array(
			'id_systeme' => (int)$result['id'],
			'type' => "Pression atmosphérique interne"
		));

		//		Température externe
		$req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type) VALUES(:id_systeme, :type)');
		$req->execute(array(
			'id_systeme' => (int)$result['id'],
			'type' => "Température externe"
		));

		//		Humidité externe
		$req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type) VALUES(:id_systeme, :type)');
		$req->execute(array(
			'id_systeme' => (int)$result['id'],
			'type' => "Humidité externe"
		));

		//		Pression atmosphérique externe
		$req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type) VALUES(:id_systeme, :type)');
		$req->execute(array(
			'id_systeme' => (int)$result['id'],
			'type' => "Pression atmosphérique externe"
		));

		//		pH
		$req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type) VALUES(:id_systeme, :type)');
		$req->execute(array(
			'id_systeme' => (int)$result['id'],
			'type' => "pH"
		));

		//		ORP
		$req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type) VALUES(:id_systeme, :type)');
		$req->execute(array(
			'id_systeme' => (int)$result['id'],
			'type' => "ORP"
		));

		//		Pression
		$req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type) VALUES(:id_systeme, :type)');
		$req->execute(array(
			'id_systeme' => (int)$result['id'],
			'type' => "Pression"
		));

		//		Ampéro
		$req = $bdd->prepare('INSERT INTO capteurs(id_systeme, type) VALUES(:id_systeme, :type)');
		$req->execute(array(
			'id_systeme' => (int)$result['id'],
			'type' => "Ampéro"
		));
	}
}
?>