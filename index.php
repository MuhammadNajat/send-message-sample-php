<!-- This file is part of Send Message Sample.

    The Send Message Sample is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    The Send Message Sample is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with The Send Message Sample.  If not, see <http://www.gnu.org/licenses/>.  --> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
	<!-- Bootstrap framework -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"
			  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
			  crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js"></script> 
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
	
	<title>Send a Test Message</title>

</head>

<body>
	<?php
		include "message.php";
		
		// Define variables for mobile number, message, and errors.
		$mNumberErr = $messageErr = "";
		$mobileNumber = $message = "";
		// Regex for the supported message characters. GSM 7-bit
		$regexForMessage = '/[^\\p{Z}{0,}a-zA-Z0-9@!\"#\\$%&\'\\(\\)\\*\\+,\\-\\.\\?\\/:<>=;]/';
		$regexPassed = TRUE;
		
		//  Data validation with PHP. Check the data after a form submit(POST)
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// Mobile number data validation will check if it is a 10 digit number. No symbols such as "-", "(", ")", etc.
			if (empty($_POST["mobileNumber"])){
				$mNumberErr = "Mobile Number is required";
			} else {
				$mobileNumber = sanitizeInput($_POST["mobileNumber"]);
				
				if (!preg_match("/^\d{10}$/",$mobileNumber)) {
				$mNumberErr = "Please enter 10 digit mobile number"; 
				}
			}
			
			// Message validation will check if it is empty and for supported characters.
			if (empty($_POST["message"])) {
				$messageErr = "Message is required";
			} else {
				$message = sanitizeInput($_POST["message"]);

				if (preg_match($regexForMessage,$message) == 1) {
					$messageErr = "Message failed. Supported characters: A-Z, a-z, 0-9, : ! @ # $ % & * ( ) + = - ' \ \" ; : , < . > / ? ";
					$message = $_POST["message"];
				}
			}
			
			// If message regex pass and mobile number field is not NULL or EMPTY.
			if($regexPassed && (!(is_null($mobileNumber) || empty($mobileNumber)))) {
				main($mobileNumber, $message);
			}
		}
		
		// Strip data of special characters and tags
		function sanitizeInput($data) {
				$data = stripslashes(trim($data));
				return $data;
			}
		
	?>
	
<div class="container">
		<center>
			<h2>Send a Test Message</h2>		
			<p>Use this form to test the power of SMS!</p>
		</center>
	<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <div class="form-group">
	    <label for="mobileNumber" class="col-sm-2 control-label">Mobile Number</label><span class="error"><?php echo $mNumberErr;?></span>
	    <div class="col-sm-10">
	      <input type="text" name="mobileNumber" class="form-control" id="mobileNumber" pattern="^\d{10}$" placeholder="5554443333" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="message" class="col-sm-2 control-label">Message</label><span class="error"><?php echo $messageErr;?></span>
	    <div class="col-sm-10">
	      <input type="text" name="message" class="form-control" id="message" pattern="/[^\\p{Z}{0,}a-zA-Z0-9@!\&quot;#\\$%&\'\\(\\)\\*\\+,\\-\\.\\?\\/:<>=;]{1,145}/">
	    </div>
	  </div>
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
	    </div>
	  </div>
	  <div><center><b>Summary Terms & Conditions:</b> By clicking submit you agree to receive 1 text message. Message and data rates may apply. Text STOP to opt out. For help, Text HELP.</center>
	</div>
	</form>
</div>
</body>
