<?php
session_start();

$id_system = isset($_COOKIE['id_system']) ? $_COOKIE['id_system'] : null;
?>

<!DOCTYPE html>
<html >
	<head>
		<meta charset="utf-8" />
		<title>Page de connexion</title>
	</head>

	<body>
		<h1>Connexion</h1>

		<div>
			<form action="index_post.php" method="post">
				<p>
					ID du système<br />
					<input type="text" name="id_system" placeholder="ID machine" value="<?php echo $id_system; ?>" required autofocus></br>
					Mot de passe<br />
					<input type="password" name="password" placeholder="Mot de passe" required></br>
					<input type="submit" name="login" value="Se connecter">
				</p>
			</form>
		</div>
	</body>
</html>