<?php
session_start();

setcookie('id_systeme', htmlspecialchars($_SESSION['id_systeme']), time() + 1*60, null, null, false, true);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Accueil</title>
	</head>

	<body>
		<?php include("header.php"); ?>

		<?php include("menu.php"); ?>

		<?php include("bdd_connect.php"); ?>

		<div>
			<h1>Pompe filtration</h1>

			<?php
			$req = $bdd->prepare('SELECT state, date_consumption, peak_consumption, off_peak_consumption FROM filtration_pump f INNER JOIN login l ON l.id = f.id_systeme WHERE f.id_systeme = :id_systeme');
			$req->execute(array(
				'id_systeme' => $_SESSION['id']));

			$donnees = $req->fetch();

			$auto_state = ($donnees['state'] == 4) ? 'marche' : 'arrêt';
			$auto_value = ($donnees['state'] == 4) ? 4 : 3;
			?>

			<fieldset>
				<legend>Etat</legend>

				<form method="post" action="homepage_post.php">
					<input type="hidden" name="table" value="filtration_pump"/>
					<input type="radio" name="state" value="<?php echo $auto_value ?>" <?php if ($donnees['state'] > 2) { echo 'checked'; } ?>/>Auto (<?php echo $auto_state; ?>)<br />
					<input type="radio" name="state" value="0" <?php if ($donnees['state'] == 0) { echo 'checked'; } ?>/>Arret<br />
					<input type="radio" name="state" value="1" <?php if ($donnees['state'] == 1) { echo 'checked'; } ?>/>Marche<br />
					<input type="submit" name="change_equipment_state" value="Modifier">
				</form>
			</fieldset>

			<fieldset>
				<legend>Consommations</legend>
				
				Date : <?php echo $donnees['date_consumption']; ?><br />
				Heures pleines : <?php echo $donnees['peak_consumption']; ?> kWh<br />
				Heures creuses : <?php echo $donnees['off_peak_consumption']; ?> kWh<br />
			</fieldset>

			<?php $req->closeCursor(); ?>
		</div>

		<div>
			<h1>Les capteurs</h1>

			<table>
				<tr>
					<th>Nom du capteur</th>
					<th>Etat</th>
					<th>Valeur</th>
				</tr>

				<?php
				$req = $bdd->prepare('SELECT * FROM sensors s INNER JOIN login l ON l.id = s.id_systeme WHERE s.id_systeme = :id_systeme');
				$req->execute(array(
					'id_systeme' => $_SESSION['id']));

				while ($donnees = $req->fetch())
				{
					if ($donnees['is_installed'] == 1)
					{
						?>
						<tr>
							<td><?php echo $donnees['type']; ?></td>
							<td><?php echo $donnees['state']; ?></td>
							<td><?php echo $donnees['value']; ?></td>
						</tr>
						<?php
					}
				}

			$req->closeCursor();
			?>
			</table>
		</div>

		<?php include("footer.php"); ?>

		<?php header('Refresh: 60'); ?>
	</body>
</html>