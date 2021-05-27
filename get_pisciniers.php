<?php
include("bdd_connect.php");

header('Content-Type: application/json');

$count = 0;
$data_pisciniers = array();


$req = $bdd->prepare('SELECT * FROM pisciniers ORDER BY id');
$req->execute();

while ($donnees = $req->fetch())
{
	$data = [ 'nom' => (string)$donnees['nom'], 'blocage' => (int)$donnees['blocage'] ];
	$data_pisciniers += [ 'piscinier' . strval(++$count) => $data ];
}

$req->closeCursor();


for ($i = 0; $i < $count; $i++) {
	$req = $bdd->prepare('SELECT COUNT(*) AS num FROM login WHERE piscinier = :piscinier');
	$req->execute(array(
		'piscinier' => $data_pisciniers['piscinier' . strval($i + 1)]['nom']
		));
	$donnees = $req->fetch();
	$data_pisciniers['piscinier' . strval($i + 1)]['nb_appareils'] = (int)$donnees['num'];
	$req->closeCursor();
}


// Format d'envoi
$output = array(
	'Pisciniers' => $data_pisciniers
);

echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>