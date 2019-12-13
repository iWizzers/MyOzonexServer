<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if (isset($_GET['couleur']) AND isset($_GET['titre']) AND isset($_GET['texte']) AND isset($_GET['dateheure'])) {
		$req = $bdd->prepare('SELECT titre, texte FROM messages WHERE id_systeme = :id_systeme AND titre = :titre AND texte = :texte');
		$req->execute(array(
			'titre' => (string)$_GET['titre'],
			'texte' => (string)$_GET['texte'],
			'id_systeme' => (int)$result['id']
			));
		$donnees = $req->fetch();

		if ((strcmp($donnees['titre'], $_GET['titre']) != 0) OR (strcmp($donnees['texte'], $_GET['texte']) != 0)) {
			$req = $bdd->prepare('INSERT INTO messages (id_systeme, couleur, titre, texte, dateheure) VALUES(:id_systeme, :couleur, :titre, :texte, :dateheure)');
			$req->execute(array(
				'couleur' => '#' . (string)$_GET['couleur'],
				'titre' => (string)$_GET['titre'],
				'texte' => (string)$_GET['texte'],
				'dateheure' => (string)$_GET['dateheure'],
				'id_systeme' => (int)$result['id']
				));
		}
	} elseif (isset($_GET['titre']) AND isset($_GET['dateheure']) AND isset($_GET['suppr'])) {
		$req = $bdd->prepare('DELETE FROM messages WHERE id_systeme = :id_systeme AND titre = :titre AND dateheure = :dateheure');
		$req->execute(array(
			'id_systeme' => (int)$result['id'],
			'titre' => (string)$_GET['titre'],
			'dateheure' => (string)$_GET['dateheure']
			));
	} elseif (isset($_GET['suppr'])) {
		$req = $bdd->prepare('DELETE FROM messages WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => (int)$result['id']
			));
	}
}
?>