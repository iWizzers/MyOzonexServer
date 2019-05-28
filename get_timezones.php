<?php
include("bdd_connect.php");

header('Content-Type: application/json');

function tz_list() {
	$zones_array = array();
	$timestamp = time();

	foreach(timezone_identifiers_list() as $i => $zone) {
		date_default_timezone_set($zone);
		$zone = explode('/',$zone);
		$zones_array[$i]['continent'] = isset($zone[0]) ? $zone[0] : '';
		$zones_array[$i]['city'] = isset($zone[1]) ? $zone[1] : '';
		$zones_array[$i]['subcity'] = isset($zone[2]) ? $zone[2] : '';
		$zones_array[$i]['diff_from_GMT'] = date('P', $timestamp);
	}

	return $zones_array;
}


$output = array();

foreach(tz_list() as $t) {
	$data = [ 'Continent' => $t['continent'], 'City' => $t['city'], 'SubCity' => $t['subcity'], 'GMT' => $t['diff_from_GMT'] ];
	$output += [ "Timezone" . strval(++$i) => $data ];
}

echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>