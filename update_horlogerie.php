<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT id FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']));
	$result = $req->fetch();

	if (isset($_GET['index_gmt'])) {
		$req = $bdd->prepare('UPDATE horlogerie SET index_gmt = :index_gmt WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'index_gmt' => (string)$_GET['index_gmt'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['plage_1'])) {
		$req = $bdd->prepare('UPDATE horlogerie SET plage_1 = :plage_1 WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'plage_1' => (string)$_GET['plage_1'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['plage_2'])) {
		$req = $bdd->prepare('UPDATE horlogerie SET plage_2 = :plage_2 WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'plage_2' => (string)$_GET['plage_2'],
			'id_systeme' => (int)$result['id']
			));
	} elseif (isset($_GET['plage_3'])) {
		$req = $bdd->prepare('UPDATE horlogerie SET plage_3 = :plage_3 WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'plage_3' => (string)$_GET['plage_3'],
			'id_systeme' => (int)$result['id']
			));
	}
}
?>