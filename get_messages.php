<?php
include("bdd_connect.php");

header('Content-Type: application/json');

$i = 0;
$data_problems = array();

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT * FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']
		));
	$donnees = $req->fetch();
	$id = (int)$donnees['id'];
	$req->closeCursor();

	if ($id != null) {
		$req = $bdd->prepare('SELECT couleur, titre, texte, dateheure FROM messages WHERE id_systeme = :id_systeme ORDER BY id ASC');
		$req->execute(array(
			'id_systeme' => $id
			));

		while ($donnees = $req->fetch())
		{
			$data = [ 'couleur' => (string)$donnees['couleur'], 'titre' => (string)$donnees['titre'], 'texte' => (string)$donnees['texte'], 'dateheure' => (string)$donnees['dateheure'] ];
			$data_problems += [ "probleme" . strval(++$i) => $data ];
		}

		$req->closeCursor();


		$output = array(
			'Problemes' => $data_problems
		);

		echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	}
}
?>