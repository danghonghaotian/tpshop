<?php
//Seller Sandbox Credentials- Sample credentials already provided
define("PP_USER_SANDBOX", "supersandy_api1.gmail.com");
define("PP_PASSWORD_SANDBOX", "1400525332");
define("PP_SIGNATURE_SANDBOX", "AdUaGhfPganVo2IfGf2Ctordn94OASnvL6qF4D-pnHb6hEQCLBWKbzmq");

//Seller Live credentials.
define("PP_USER","seller_username_here");
define("PP_PASSWORD", "seller_password_here");
define("PP_SIGNATURE","seller_signature_here");

//The URL in your application where Paypal returns control to -after success (RETURN_URL) and after cancellation of the order (CANCEL_URL) 
define("RETURN_URL",'http://'.$_SERVER['HTTP_HOST'].preg_replace('/paypal_ec_redirect.php/','review.php',$_SERVER['SCRIPT_NAME']));
define("CANCEL_URL",'http://'.$_SERVER['HTTP_HOST'].preg_replace('/paypal_ec_redirect.php/','cancel.php',$_SERVER['SCRIPT_NAME']));

//Whether Sandbox environment is being used, Keep it true for testing
define("SANDBOX_FLAG", true);

//Proxy Config
define("PROXY_HOST", "127.0.0.1");
define("PROXY_PORT", "808");

//Express Checkout URLs for Sandbox
define("PP_CHECKOUT_URL_SANDBOX", "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=");
define("PP_NVP_ENDPOINT_SANDBOX","https://api-3t.sandbox.paypal.com/nvp");

//Express Checkout URLs for Live
define("PP_CHECKOUT_URL_LIVE","https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=");
define("PP_NVP_ENDPOINT_LIVE","https://api-3t.paypal.com/nvp");

//Version of the APIs
define("API_VERSION", "109.0");

//ButtonSource Tracker Code
define("SBN_CODE","PP-DemoPortal-PPCredit-php");
?>