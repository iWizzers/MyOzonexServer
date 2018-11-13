<?php
// Connexion à la base de données
try
{
	// Local
	$bdd = new PDO('mysql:host=localhost;dbname=dbo734728870;charset=utf8', 'root', '');

	// Serveur
	//$bdd = new PDO('mysql:host=db734728870.db.1and1.com;dbname=db734728870;charset=utf8', 'dbo734728870', 'HgetRFdhG!@dj7eks8952dlsujeTgdsfR');
}
catch(Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}
?>