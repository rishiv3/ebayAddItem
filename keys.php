<?php
/*  © 2007-2013 eBay Inc., All Rights Reserved */
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */

    //show all errors - useful whilst developing
    error_reporting(E_ALL);

    // these keys can be obtained by registering at http://developer.ebay.com
    
    $production         = true;   // toggle to true if going against production
    $compatabilityLevel = 825;    // eBay API version
    
    if ($production) {
        $devID = 'Production_devID';   // these prod keys are different from sandbox keys
        $appID = 'Production_appID';
        $certID = 'Production_certID';
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        //the token representing the eBay user to assign the call with
        $userToken = 'Production_usertoken'; 
        $paypalEmailAddress= 'PAYPAL_EMAIL_ADDRESS';		
    } else {  
        $devID = 'sandbox_devID';         // insert your devID for sandbox
        $appID = 'sandbox_appID';   // different from prod keys
        $certID = 'sandbox_certID';  // need three 'keys' and one token
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
        // the token representing the eBay user to assign the call with
        // this token is a long string - don't insert new lines - different from prod token
        $userToken = 'sandbox_usertoken'; 
		$paypalEmailAddress = 'SANDBOX_PAYPAL_EMAIL_ADDRESS';		
    }
?>
