<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();
	$id = (int)$result['id'];

	if (isset($_GET['texte']) AND isset($_GET['dateheure']) AND isset($_GET['couleur'])) {
		$req = $bdd->prepare('SELECT texte, COUNT(*) AS num FROM events WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => $id
			));
		$donnees = $req->fetch();
		$nbEvents = (int)$donnees['num'];
		$req->closeCursor();

		$req = $bdd->prepare('SELECT id FROM events WHERE id_systeme = :id_systeme ORDER BY id');
		$req->execute(array(
			'id_systeme' => $id
			));
		$donnees = $req->fetch();
		$idFirstEvent = (int)$donnees['id'];
		$req->closeCursor();

		if ($nbEvents >= 100) {
			$req = $bdd->prepare('DELETE FROM events WHERE id = :id');
			$req->execute(array(
				'id' => $idFirstEvent
				));
		}

		$req = $bdd->prepare('INSERT INTO events (id_systeme, texte, couleur, dateheure) VALUES(:id_systeme, :texte, :couleur, :dateheure)');
		$req->execute(array(
			'texte' => (string)$_GET['texte'],
			'couleur' => (int)$_GET['couleur'],
			'dateheure' => (string)$_GET['dateheure'],
			'id_systeme' => $id
			));
	} elseif (isset($_GET['texte']) AND isset($_GET['dateheure']) AND isset($_GET['lu'])) {
		$req = $bdd->prepare('UPDATE events SET lu = :lu WHERE id_systeme = :id_systeme AND texte = :texte AND dateheure = :dateheure');
		$req->execute(array(
			'lu' => (int)$_GET['lu'],
			'id_systeme' => $id,
			'texte' => (string)$_GET['texte'],
			'dateheure' => (string)$_GET['dateheure']
			));
	} elseif (isset($_GET['texte']) AND isset($_GET['dateheure']) AND isset($_GET['suppr'])) {
		$req = $bdd->prepare('DELETE FROM events WHERE id_systeme = :id_systeme AND texte = :texte AND dateheure = :dateheure');
		$req->execute(array(
			'id_systeme' => $id,
			'texte' => (string)$_GET['texte'],
			'dateheure' => (string)$_GET['dateheure']
			));
	} elseif (isset($_GET['suppr'])) {
		$req = $bdd->prepare('DELETE FROM events WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'id_systeme' => $id
			));
	}
}
?>