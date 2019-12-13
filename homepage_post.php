<?php
session_start();

include("bdd_connect.php");

if (isset($_POST['change_equipment_state'])) {
	$req = $bdd->prepare('UPDATE ' . $_POST['table'] . ' SET state = :state WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'state' => (int)$_POST['state'],
		'id_systeme' => (int)$_SESSION['id']
		));
}

// Redirection du visiteur vers la page principale
header('Location: homepage.php');
?>