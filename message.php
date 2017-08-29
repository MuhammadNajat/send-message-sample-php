<?php
/* This file is part of Send Message Sample.

	The Send Message Sample is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	at your option) any later version.
	
	The Send Message Sample is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with The Send Message Sample.  If not, see <http://www.gnu.org/licenses/>.	
	
	* Program Work flow
 	* 1. Recipient submits contact information into form.
 	* 2. API receives the data.
 	* 3. Use Direct SMS to send out a message.
	*/

// It is important to download and include the "request_rest.php" file.
include "request_rest.php";

// File contains information for debugging.
include "info.php";

// Account information and validation.
// Replace $myUsername with the proper username and $myKey with the API key
$apikey = $myKey;
$username = $myUsername;

function main($mobileNumber, $message) {
	message($mobileNumber, $message);
	
	return;
}

// This function will send a message
function message($mobileNumber, $message) {

	// Account information
	global $apikey, $username;
	
	// Generating the URL to search for a subscription
	$request_url = "http://api.trumpia.com/rest/v1/" . $username . "/sms";
	
	// Message parameters and values
	$request_data = array(
		"mobile_number" => $mobileNumber,
		"message" => $message
		);
	
	// Creating a request
	$request_rest = new RestRequest();
	$request_rest->setRequestURL($request_url);
	$request_rest->setAPIKey($apikey);
	$request_rest->setRequestBody(json_encode($request_data));
	$request_rest->setMethod("PUT");
	$result = $request_rest->execute();
	$response_status = $result[0];
	$json_response_data = $result[1];
	    
	// Decode the JSON response into a string.
	$json_data = json_decode($json_response_data, true);
	// Store the request_id and status_code into strings from the JSON response
	$request_id = $json_data["request_id"];
	$status_code = $json_data["status_code"];
	
	// Send the variables to GET Report. GET Report is used to check the status of the request.
	getReport($request_id, $status_code);
	
	return;
}

// This function will use the request_id to check the status of the request.
// The JSON response will have the status_code. The status_code will tell us about any errors.
function getReport($request_id, $status_code) {
	
	// Account information
	global $apikey, $username;
	
	// Generate the URL to check the status of the request.
	$request_url = "http://api.trumpia.com/rest/v1/" . $username . "/report/" . $request_id;
	$request_rest = new RestRequest();
	$request_rest->setRequestURL($request_url);
	$request_rest->setAPIKey($apikey);
	$request_rest->setMethod("GET");
	$result = $request_rest->execute();
	$response_status = $result[0];
	$json_response_data = $result[1];
		    
	// Decode the JSON response into a string
	$json_data = json_decode($json_response_data, true);

	// Check to see if the "status" parameter exists in the JSON response.
	// This status will tell you if the message was sent or failed.
	if(array_key_exists("status", $json_data)){
		$status = $json_data["status"];
			if($status == "sent"){
				alert("Message Sent");
			} else {
				alert("Message Failed");
			}
			
	// Check to see if the "status_code" parameter exists in the JSON response.
	// Use the status_code to identify any issues.
	} elseif(isset($json_data["status_code"])) {
		// Store the status_code in a string
		$status_code = $json_data["status_code"];
		
		// The system is still processing the request if the status code is MPCE4001
		// Continue to GET Report if status_code is in progress
		// Information on status codes can be found at: http://api.trumpia.com/docs/rest/status-code.php
		if($status_code == "MPCE4001"){
			sleep(1);
			getReport($request_id, $status_code);
		} elseif($status_code == "MRME1054") {
			alert("Message Failed - too many characters.");

		// Status code MPSE0501 means the phone number has texted STOP to the short code and is blocked.
		// The mobile device can text HELP to the SHORT CODE to remove this block.
		} elseif($status_code == "MRME0551") {
			alert("Mobile number is blocked.");
		} elseif($status_code == "MRME1251") {
			alert("Message failed - Alphanumeric and the following characters are supported: \@\!\#\$\%\&\(\)\*\+\,\-\.\?\/\:\;\<\=\>\'\"");
		}
	}
	
	return $json_data;
}

// Javascript pop-up error message function
function alert($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
}

?>