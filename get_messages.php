<?php
include("bdd_connect.php");

header('Content-Type: application/json');

$data = array();
$i = 0;

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$donnees = $req->fetch();
	$req->closeCursor();

	$req = $bdd->prepare('SELECT couleur, titre, texte, dateheure FROM messages WHERE id_systeme = :id_systeme ORDER BY id ASC');
	$req->execute(array(
		'id_systeme' => (int)$donnees['id']));
	while ($donnees = $req->fetch()) {
		$data['msg' . strval(++$i)][(string)$donnees['couleur'] . ';' . (string)$donnees['titre']] = (string)$donnees['texte'] . ';' . (string)$donnees['dateheure'];
	}
	$req->closeCursor();
}

// Format d'envoi
$output = array(
	'Data' => $data
);

echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>