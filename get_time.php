<?php
include("bdd_connect.php");
include("api.php");

header('Content-Type: application/json');


if (isset($_GET['id_systeme'])) {
    $req = $bdd->prepare('SELECT id, ville FROM login WHERE id_systeme = :id_systeme');
    $req->execute(array(
        'id_systeme' => (string)$_GET['id_systeme']));
    $result = $req->fetch();

    $req = $bdd->prepare('UPDATE horlogerie SET index_gmt = :index_gmt WHERE id_systeme = :id_systeme');
    $req->execute(array(
        'index_gmt' => (string)get_timezone_from_coordinates(get_coordinates((string)$result['ville'])),
        'id_systeme' => (int)$result['id']
        ));

	echo get_datetime_from_nearest_timezone(get_coordinates((string)$result['ville']));
}
?>