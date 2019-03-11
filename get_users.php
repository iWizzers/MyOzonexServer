<?php
include("bdd_connect.php");

header('Content-Type: application/json');

$req = $bdd->prepare('SELECT id_systeme, proprietaire, alive, version, block FROM login ORDER BY id ASC');
$req->execute();
$donnees = $req->fetch();

$data_users = array();
$i = 0;
while ($donnees = $req->fetch())
{
	$data = [ "id_systeme" => (string)$donnees['id_systeme'], "proprietaire" => (string)$donnees['proprietaire'], "alive" => (string)$donnees['alive'], "version" => (string)$donnees['version'], "blocage" => (int)$donnees['block'] ];
	$data_users += [ "user" . strval(++$i) => $data ];
}

$req->closeCursor();

// Format d'envoi
$output = array(
	'Users' => $data_users
);

echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>