<?php
$BackendURL = getenv('API_URL');

function callAPI($method, $url, $data){
		$curl = curl_init();

		switch ($method){
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			default:
				if ($data)
					$url = sprintf("%s?%s", $url, http_build_query($data));
		}

		// OPTIONS:
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'APIKEY: 111111111111111111111',
			'Accept: application/xml',
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		// Change service account before production
		curl_setopt($curl, CURLOPT_USERPWD, getenv('API_User') . ":" . getenv('API_Password'));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

		// EXECUTE:
		$result = curl_exec($curl);
		if(!$result){die("Connection Failure");}
		curl_close($curl);
		return $result;
	}


switch ($_GET['type']){
  case "device":
    $APIEntrypoint = '/JSSResource/mobiledevices/serialnumber/';
    $RedirectURI = '/mobileDevices.html?id=';
    $ParsePatern = '<mobile_device>';
    break;
  case "computer":
    $APIEntrypoint = '/JSSResource/computers/serialnumber/';
    $RedirectURI = '/computers.html?id=';
    $ParsePatern = '<computer>';
    break;
	default:
		http_response_code(400);
		exit(1);
		break;
}

$query = $BackendURL . $APIEntrypoint . ($_GET['sn']);

$respond = callAPI('GET',$query, false);

$DeviceID = substr($respond, strpos($respond, $ParsePatern) + 0);

preg_match('/<general><id>(.*?)<\/id>/', $DeviceID, $find);

header("Location: $BackendURL$RedirectURI$find[1]&o=r", true, 307);

?>
