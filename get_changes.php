<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	$req = $bdd->prepare('SELECT * FROM login WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => (string)$_GET['id_systeme']
	));
	$donnees = $req->fetch();

	$id = (int)$donnees['id'];
	$version = (string)$donnees['version'];

	if ($id != null) {
		if (explode(".", $version)[0] == '1') {
			echo (int)$donnees['changes_from_app'];
		} else {
			echo '<' . (int)$donnees['changes_from_app'] . '>';
		}
	}

	$req->closeCursor();
}
?>