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

    $date = get_datetime_from_coordinates(get_coordinates_from_address((string)$donnees['ville']));

    $req = $bdd->prepare('UPDATE horlogerie SET index_gmt = :index_gmt, timezone = :timezone WHERE id_systeme = :id_systeme');
    $req->execute(array(
        'index_gmt' => 'GMT' . $date->format('P'),
        'timezone' => $date->getTimezone()->getName(),
        'id_systeme' => (int)$donnees['id']
        ));

    if ((int)$donnees['type_appareil'] > 1) {
        echo '<';
    }

    echo $date->format(((int)$donnees['type_appareil'] > 1 ? 'N/' : '') . 'd/m/Y H:i:s');

    if ((int)$donnees['type_appareil'] > 1) {
        echo '>';
    }
}
?>