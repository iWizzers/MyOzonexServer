<?php
include("bdd_connect.php");
include("api.php");

$req = $bdd->prepare('SELECT id, ville FROM login WHERE id_systeme = :id_systeme');
$req->execute(array(
	'id_systeme' => 'DEMO-0001'));
$result = $req->fetch();
$id = (int)$result['id'];
$ville = (string)$result['ville'];

for ($i = 0; $i < 55; $i++) {
	$req = $bdd->prepare('SELECT timezone FROM horlogerie WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'id_systeme' => $id));
	$result = $req->fetch();

	$date = new DateTime("now", new DateTimeZone((string)$result['timezone'])); 

	$req = $bdd->prepare('UPDATE login SET alive = :alive WHERE id_systeme = :id_systeme');
	$req->execute(array(
		'alive' => $date->format('d/m/Y-H:i'),
		'id_systeme' => 'DEMO-0001'
		));

	if ($date->diff(new DateTime('05:00:00', new DateTimeZone((string)$result['timezone'])))->format('%R') == '+') {
		$date = get_datetime_from_coordinates(get_coordinates_from_address($ville));

		$req = $bdd->prepare('UPDATE horlogerie SET index_gmt = :index_gmt, timezone = :timezone WHERE id_systeme = :id_systeme'); 
	    $req->execute(array( 
	        'index_gmt' => 'GMT' . $date->format('P'),
	        'timezone' => $date->getTimezone()->getName(),
	        'id_systeme' => $id
	        ));
	}

	sleep(60);
}
?>