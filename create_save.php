<?php
$date = new DateTime("now");
$dirName = '../saves';
$nbMaxSaves = 30;
$files = glob("$dirName/*"); //Get a list of file paths using the glob function

//Loop through the array that glob returned.
foreach ($files as $file) {
	//Simply print them out onto the screen.
	if (strpos($file, $date->format('dmY')) !== false) {
		return;
	}
}

// Local
/*$mysqlDatabaseName = 'db734728870';
$mysqlUserName = 'root';
$mysqlPassword = '';
$mysqlHostName = 'localhost';
$mysqlExportPath = $dirName . '/save' . $date->format('dmYHis') . '.sql';*/
// Server
$mysqlDatabaseName = 'db734728870';
$mysqlUserName = 'dbo734728870';
$mysqlPassword = 'HgetRFdhG!@dj7eks8952dlsujeTgdsfR';
$mysqlHostName = 'db734728870.db.1and1.com';
$mysqlExportPath = $dirName . '/save' . $date->format('dmYHis') . '.sql';

//Exportation de la base de données et résultat
$command = 'mysqldump --opt -h' . $mysqlHostName . ' -u' . $mysqlUserName . ' -p' . $mysqlPassword . ' ' . $mysqlDatabaseName . ' > ' . $mysqlExportPath;
$output=array();
exec($command, $output, $worked);

if ($worked == 0) {	
	if (count($files) >= $nbMaxSaves) {
		// Sort files by modified time, latest to earliest
		// Use SORT_ASC in place of SORT_DESC for earliest to latest
		array_multisort(
		array_map('filemtime', $files),
		SORT_NUMERIC,
		SORT_ASC,
		$files
		);

		unlink($files[0]);
	}
} else {
	unlink($mysqlExportPath);
}

/*switch ($worked) {
case 0:
	echo 'La base de données <b>' . $mysqlDatabaseName . '</b> a été stockée avec succès dans le chemin suivant ' . getcwd() . '/' . $mysqlExportPath .'</b>';
	break;
case 1:
	echo 'Une erreur s\'est produite lors de l\'exportation de <b>' . $mysqlDatabaseName . '</b> vers ' . getcwd() . '/' . $mysqlExportPath .'</b>';
	break;
case 2:
	echo 'Une erreur d\'exportation s\'est produite, veuillez vérifier les informations suivantes : <br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' . $mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' . $mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' . $mysqlHostName .'</b></td></tr></table>';
break;
}*/
?>