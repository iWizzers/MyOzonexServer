<?php
session_start();

setcookie('id_system', htmlspecialchars($_SESSION['id_system']), time() + 1*60, null, null, false, true);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Root</title>
	</head>

	<body>
		<?php include("header.php"); ?>

		<?php include("menu.php"); ?>

		<?php include("bdd_connect.php"); ?>

		<div>
			<table>
				<tr>
					<th>ID système</th>
					<th>Etat</th>
					<th>Action</th>
				</tr>

				<?php
				$req = $bdd->query('SELECT id, id_system, block FROM login');

				while ($donnees = $req->fetch())
				{
					if ($donnees['id'] > 1)
					{
						$block_state = ($donnees['block'] == 0) ? 'Débloqué' : 'Bloqué';
						$block_button = ($donnees['block'] == 0) ? 'Bloquer' : 'Débloquer';
						$block_post = ($donnees['block'] == 0) ? 1 : 0;
						?>

						<tr>
							<td><?php echo $donnees['id_system']; ?></td>
							<td><?php echo $block_state; ?></td>
							<td>
								<form action="root_post.php" method="post">
									<input type="hidden" name="block" value="<?php echo $block_post; ?>"/>
									<input type="hidden" name="id" value="<?php echo $donnees['id']; ?>"/>
									<button type="submit"><?php echo $block_button ?></button>
								</form>
							</td>
						</tr>
						<?php
					}
				}

			$req->closeCursor();
			?>
			</table>
		</div>

		<?php include("footer.php"); ?>
	</body>
</html>
