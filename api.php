<?php
$API_KEY='AIzaSyCxVtrpaAk7ZQljPxI_tGHuSeOPcQNlzb8';


function get_coordinates_from_google_api($address) {
    global $API_KEY;
    $prepAddr = str_replace(' ','+',$address);
	$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key='.$API_KEY);
	$output= json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
	return array($latitude, $longitude);
}


function get_datetime_from_google_api($coordinates) {
    global $API_KEY;
	$time = time();
    $url = 'https://maps.googleapis.com/maps/api/timezone/json?location='.$coordinates[0].','.$coordinates[1].'&timestamp='.$time.'&key='.$API_KEY;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$responseJson = curl_exec($ch);
	curl_close($ch);
	 
	$response = json_decode($responseJson);
	$timezone = $response->timeZoneId;
	$date = new DateTime("now");

	if (!empty($timezone)) {
		$date->setTimezone(new DateTimeZone($timezone));
	}
	
	return $date->format('d-m-Y H:i:s');
}


function get_datetime_from_coordinates($coordinates, $country_code = '') {
    $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code)
                                    : DateTimeZone::listIdentifiers();
    $time_zone = '';

    if($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {
        $tz_distance = 0;

        //only one identifier?
        if (count($timezone_ids) == 1) {
            $time_zone = $timezone_ids[0];
        } else {
            foreach($timezone_ids as $timezone_id) {
                $timezone = new DateTimeZone($timezone_id);
                $location = $timezone->getLocation();
                $tz_lat   = $location['latitude'];
                $tz_long  = $location['longitude'];

                $theta    = $coordinates[1] - $tz_long;
                $distance = (sin(deg2rad($coordinates[0])) * sin(deg2rad($tz_lat))) 
                + (cos(deg2rad($coordinates[0])) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                $distance = acos($distance);
                $distance = abs(rad2deg($distance));

                if (!$time_zone || $tz_distance > $distance) {
                    $time_zone   = $timezone_id;
                    $tz_distance = $distance;
                }
            }
        }
    }

    return new DateTime("now", new DateTimeZone($time_zone));
}


function get_coordinates_from_address($address) {
    $geocode = file_get_contents('http://open.mapquestapi.com/geocoding/v1/address?key=0t7AdxmKbrlWocm0Kvb4m6jtxGKPaICz&location=' . $address);
    $output = json_decode($geocode);
    $latitude = $output->results[0]->locations[0]->latLng->lat;
    $longitude = $output->results[0]->locations[0]->latLng->lng;
    return array($latitude, $longitude);
}
?>