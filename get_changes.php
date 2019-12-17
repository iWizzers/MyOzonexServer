<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT * FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']
	));
	$donnees = $req->fetch();

	$id = (int)$donnees['id'];

	if ($id != null) {
		$change = (int)$donnees['changes_from_app'];

		echo $change;
	}

	$req->closeCursor();
}
?>