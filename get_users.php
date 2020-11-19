<?php
include("bdd_connect.php");

header('Content-Type: application/json');

$login_count = 0;
$data_users = array();

$version = isset($_GET['version']) ? $_GET['version'] : '1.0.0';

$req = $bdd->prepare('SELECT * FROM login ORDER BY proprietaire ASC');
$req->execute();
$donnees = $req->fetch(); // Saute utilisateur "admin"

while ($donnees = $req->fetch())
{
	$data = [ 'id_systeme' => (string)$donnees['id_systeme'], 'proprietaire' => (string)$donnees['proprietaire'], 'coordonnees' => (string)$donnees['coordonnees'], 'ville' => (string)$donnees['ville'], 'type_connexion' => (int)$donnees['type_connexion'], 'alive' => (string)$donnees['alive'], 'version' => (string)$donnees['version'], 'blocage' => (int)$donnees['block'], 'type_appareil' => (int)$donnees['type_appareil'], 'piscinier' => (string)$donnees['piscinier'] ];

	if ((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '3') && (explode(".", $version)[2] >= '2')) {
		$data['date_pose'] = (string)$donnees['date_pose'];
	}

	$data_users += [ "user" . strval(++$login_count) => $data ];
}

$req->closeCursor();

for ($i = 0; $i < $login_count; $i++) {
	$req = $bdd->prepare('SELECT * FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => $data_users['user' . strval($i + 1)]['id_systeme']
		));
	$donnees = $req->fetch();
	$id = (int)$donnees['id'];
	$req->closeCursor();

	$req = $bdd->prepare('SELECT index_gmt FROM horlogerie WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => $id
		));
	$donnees = $req->fetch();
	$data_users['user' . strval($i + 1)]['index_gmt'] = (string)$donnees['index_gmt'];
	$req->closeCursor();

	if ((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '3') && (explode(".", $version)[2] >= '2')) {
		$req = $bdd->prepare('SELECT type, installe, etat, valeur FROM capteurs WHERE id_systeme = :id_systeme ORDER BY id ASC');
		$req->execute(array(
			'id_systeme' => $id
			));
		while ($donnees = $req->fetch())
		{
			$data_users['user' . strval($i + 1)][(string)$donnees['type']] = (int)$donnees['installe'] . ';' . (string)$donnees['etat'] . ';' . (double)$donnees['valeur'];
		}
		$req->closeCursor();
	}

	if ((explode(".", $version)[0] == '2') && (explode(".", $version)[1] >= '3') && (explode(".", $version)[2] >= '2')) {
		$req = $bdd->prepare('SELECT couleur, titre, texte, dateheure FROM messages WHERE id_systeme = :id_systeme ORDER BY id ASC');
		$req->execute(array(
			'id_systeme' => $id
			));
		while ($donnees = $req->fetch())
		{
			$data_users['user' . strval($i + 1)][(string)$donnees['couleur'] . ';' . (string)$donnees['titre']] = (string)$donnees['texte'] . ';' . (string)$donnees['dateheure'];
		}
	} else {
		$req = $bdd->prepare('SELECT couleur, COUNT(*) AS num FROM messages WHERE id_systeme = :id_systeme GROUP BY couleur');
		$req->execute(array(
			'id_systeme' => $id
			));
		while ($donnees = $req->fetch())
		{
			$data_users['user' . strval($i + 1)][(string)$donnees['couleur']] = (int)$donnees['num'];
		}
	}
	$req->closeCursor();
}

// Format d'envoi
$output = array(
	'Users' => $data_users
);

echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>