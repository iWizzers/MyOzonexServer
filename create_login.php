<?php
include("api.php");

$pass = false;

if (isset($_GET['id_systeme']) AND isset($_GET['password']) AND isset($_GET['alive'])) {
	// Vérifie si la base de données de l'utilisateur existe
	$req = $bdd->prepare('SELECT EXISTS (SELECT * FROM login WHERE id_systeme = :id_systeme) AS login_exists');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if (!$result['login_exists']) {
		create_new_device((string)$_GET['id_systeme'], (string)$_GET['password']);
		$pass = "LOG OK";
	} else {
		$pass = "LOG EXISTS";
	}
} elseif (isset($_GET['generer_id_mdp'])) {
	do {
		// Gen ID
		$id = "";

		for ($i = 0; $i < 8; $i++) { 
			$rand_value = get_random_int(48, 91);

			if (((48 <= $rand_value) && ($rand_value <= 57)) || ((65 <= $rand_value) && ($rand_value <= 90))) {
				$id .= chr($rand_value);

				if ($i == 3) {
					$id .= '-';
				}
			} else {
				$i--;
			}
		}
		
		// Gen password
		$mdp = "";

		for ($i = 0; $i < 6; $i++) { 
			$rand_value = get_random_int(48, 123);

			if (((48 <= $rand_value) && ($rand_value <= 57)) || ((97 <= $rand_value) && ($rand_value <= 122))) {
				$mdp .= chr($rand_value);
			} else {
				$i--;
			}
		}

		$req = $bdd->prepare('SELECT EXISTS (SELECT * FROM login WHERE id_systeme = :id_systeme) AS login_exists');
		$req->execute(array(
			'id_systeme' => $id));
		$result = $req->fetch();
	} while ($result['login_exists']);

	create_new_device($id, $mdp);

	echo "< $id;$mdp>";
} else {
	$pass = "LOG ERROR";
}

if (!empty($pass)) {
	echo $pass;
}
?>