<?php
	$myFile = fopen("output.txt", "w");
	$oauth = "1f9c5c81-e087-4831-aa65-afa1b69f8c11:aa1f45ab-2283-44de-9029-af7cb7d17e2c";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "https://holyghostprep.powerschool.com/oauth/access_token/");
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_USERPWD, $oauth);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
	$result = curl_exec($curl);
	curl_close($curl);
	if ($result === false) {
		fwrite("myFile", "Curl error: ".curl_error($curl));
	}else {
		fwrite($myFile, $result);
	}
	echo date('l jS \of F Y h:i:s A');
?>