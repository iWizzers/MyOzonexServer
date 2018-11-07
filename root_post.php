<?php
include("bdd_connect.php");

if (isset($_POST['block']) AND isset($_POST['id'])) {
	$req = $bdd->prepare('UPDATE login SET block = :block WHERE id = :id');
	$req->execute(array(
		'block' => (int)$_POST['block'],
		'id' => (int)$_POST['id']
		));
}

header('Location: root.php');
?>