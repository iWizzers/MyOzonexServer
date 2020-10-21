<?php
include("bdd_connect.php");

header('Content-Type: application/json');

$login_count = 0;
$data_users = array();

if (isset($_GET['piscinier'])) {
	$req = $bdd->prepare('SELECT * FROM login WHERE piscinier = :piscinier ORDER BY proprietaire ASC');
	$req->execute(array(
		'piscinier' => (string)$_GET['piscinier']
		));
} else {
	$req = $bdd->prepare('SELECT * FROM login ORDER BY proprietaire ASC');
	$req->execute();
	$donnees = $req->fetch(); // Saute utilisateur "admin"
}

while ($donnees = $req->fetch())
{
	$data = [ 'id_systeme' => (string)$donnees['id_systeme'], 'proprietaire' => (string)$donnees['proprietaire'], 'coordonnees' => (string)$donnees['coordonnees'], 'ville' => (string)$donnees['ville'], 'type_connexion' => (int)$donnees['type_connexion'], 'alive' => (string)$donnees['alive'], 'version' => (string)$donnees['version'], 'blocage' => (int)$donnees['block'], 'type_appareil' => (int)$donnees['type_appareil'], 'piscinier' => (string)$donnees['piscinier'] ];
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

	$req = $bdd->prepare('SELECT couleur, COUNT(*) AS num FROM messages WHERE id_systeme = :id_systeme GROUP BY couleur');
	$req->execute(array(
		'id_systeme' => $id
		));
	while ($donnees = $req->fetch())
	{
		$data_users['user' . strval($i + 1)][(string)$donnees['couleur']] = (int)$donnees['num'];
	}
	$req->closeCursor();
}

// Format d'envoi
$output = array(
	'Users' => $data_users
);

echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>