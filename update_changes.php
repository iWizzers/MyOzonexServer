<?php
include("bdd_connect.php");

if (isset($_GET['id_systeme'])) {
	if (isset($_GET['changes_from_app'])) {
		$req = $bdd->prepare('UPDATE login SET changes_from_app = :changes_from_app WHERE id_systeme = :id_systeme');
		$req->execute(array(
			'changes_from_app' => (int)$_GET['changes_from_app'],
			'id_systeme' => (string)$_GET['id_systeme']
			));
	}
}
?>