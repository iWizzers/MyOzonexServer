<?php
include("bdd_connect.php");
include("api.php");

header('Content-Type: application/json');


if (isset($_GET['id_systeme'])) {
    $req = $bdd->prepare('SELECT id, ville, type_appareil FROM login WHERE id_systeme = :id_systeme');
    $req->execute(array(
        'id_systeme' => (string)$_GET['id_systeme']));
    $donnees = $req->fetch();
    $req->closeCursor();

    $req = $bdd->prepare('UPDATE horlogerie SET index_gmt = :index_gmt WHERE id_systeme = :id_systeme');
    $req->execute(array(
        'index_gmt' => (string)get_timezone_from_coordinates(get_coordinates((string)$donnees['ville'])),
        'id_systeme' => (int)$donnees['id']
        ));
    $req->closeCursor();

    if ((int)$donnees['type_appareil'] == 2) {
        echo '<';
    }

	echo get_datetime_from_nearest_timezone(get_coordinates((string)$donnees['ville']), (int)$donnees['type_appareil']);

    if ((int)$donnees['type_appareil'] == 2) {
        echo '>';
    }
}
?>