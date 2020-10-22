<?php
include("bdd_connect.php");
include("api.php");

header('Content-Type: application/json');


if (isset($_GET['id_systeme'])) {
    /*$address = getaddress(explode(",", $details->loc)[0], explode(",", $details->loc)[1]);
    if ($address) {
        echo $address . "<br>";
    } else {
        echo "Not found<br>";
    }*/

    $details = json_decode(file_get_contents("http://ipinfo.io/{$_SERVER['REMOTE_ADDR']}/json"));
    $date = new DateTime("now", new DateTimeZone($details->timezone));

    $req = $bdd->prepare('UPDATE login SET ville = :ville WHERE id_systeme = :id_systeme');
    $req->execute(array(
        'ville' => $details->postal . ' ' . $details->city . ', ' . $details->country,
        'id_systeme' => (string)$_GET['id_systeme']
        ));

    $req = $bdd->prepare('SELECT id, type_appareil FROM login WHERE id_systeme = :id_systeme');
    $req->execute(array(
        'id_systeme' => (string)$_GET['id_systeme']));
    $donnees = $req->fetch();
    $req->closeCursor();

    $req = $bdd->prepare('UPDATE horlogerie SET index_gmt = :index_gmt, timezone = :timezone WHERE id_systeme = :id_systeme');
    $req->execute(array(
        'index_gmt' => 'GMT' . $date->format('P'),
        'timezone' => $details->timezone,
        'id_systeme' => (int)$donnees['id']
        ));

    if ((int)$donnees['type_appareil'] == 2) {
        echo '<';
    }

    echo $date->format(((int)$donnees['type_appareil'] == 2 ? 'N/' : '') . 'd/m/Y H:i:s');

    if ((int)$donnees['type_appareil'] == 2) {
        echo '>';
    }
}
?>