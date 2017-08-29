# Trumpia API #
Trumpia API enables users to seamlessly integrate our technologies into their application. And with high throughput rates, a free shared short code, and included web-based user interface, we offer a complete and unmatched suite of SMS messaging functionalities. This is just one of those many powerful use cases.

#### [Click here to sign up for free Trumpia account!](https://api.trumpia.com) ####

[Trumpia Home Page](https://trumpia.com)

[REST API Documentation](http://api.trumpia.com/docs/rest/overview.php)

# Overview #
This PHP application example demonstrates how to implement `PUT` Direct SMS and `GET` REPORT using Trumpia's RESTful API. Direct SMS enables you to send a message without having to add the subscription into the database. The HTML web page utilizes Bootstrap for the theme and design. This simplifies the page and makes it responsive.

Bootstrap can be installed multiple ways, but the code has been included into the sample code between the `<head>` tags. Feel free to make adjustments to change the look and feel. Visit [GetBootStrap](https://getbootstrap.com/docs/4.0/getting-started/introduction/) to learn more.

#### Languages: ####
1. PHP 5.6.22
2. HTML5 & Bootstrap
3. Javascript

#### REST API functions used: ####
1. PUT Direct SMS
2. GET Status Report

#### Information collected on web form: ####
1. Mobile number
2. Message contents

# Application Workflow #
Once the user enters the data, the application will check the status of the request. HTML5 along with Javascript is used for input data validation. The request is then checked with our REST API function GET REPORT.

The user will receive a Javascript confirmation pop-up if:
1. The message was sent successfully
2. The message failed to be sent

# Understanding Status Codes #
Descriptions of the different status code(s) can be found within the [Direct SMS status code documentation](http://trumpia.com/api/docs/rest/status-code/direct-sms.php#put). Common status codes for failed messages:
* **MRME1054:** Too many characters (exceeded 160 characters)
* **MRME0551:** Mobile number is blocked
* **MRME1251:** Alphanumeric and the following characters are supported: \@\!\#\$\%\&\(\)\*\+\,\-\.\?\/\:\;\<\=\>\'\

#### Need some help? Found a bug? Please email [apisupport@mytrum.com](mailto:apisupport@mytrum.com) with any questions! ####
