<?php
   require_once("paypal_functions.php");
  
   //Call to SetExpressCheckout using the shopping parameters collected from the shopping form on index.php and few from config.php 

   $returnURL = RETURN_URL;
   $cancelURL = CANCEL_URL; 
   
   if(isset($_POST["PAYMENTREQUEST_0_ITEMAMT"]))
   $_POST["L_PAYMENTREQUEST_0_AMT0"]=$_POST["PAYMENTREQUEST_0_ITEMAMT"];

   $resArray = CallShortcutExpressCheckout ($_POST, $returnURL, $cancelURL);
   $ack = strtoupper($resArray["ACK"]);
   if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")  //if SetExpressCheckout API call is successful
   {
   	RedirectToPayPal ( $resArray["TOKEN"] );
   } 
   else  
   {
   	//Display a user friendly Error on the page using any of the following error information returned by PayPal
   	$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
   	$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
   	$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
   	$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
   	
   	echo "SetExpressCheckout API call failed. ";
   	echo "Detailed Error Message: " . $ErrorLongMsg;
   	echo "Short Error Message: " . $ErrorShortMsg;
   	echo "Error Code: " . $ErrorCode;
   	echo "Error Severity Code: " . $ErrorSeverityCode;
   }
   
?>