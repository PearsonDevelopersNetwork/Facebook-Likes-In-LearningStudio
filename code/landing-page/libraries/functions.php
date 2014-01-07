<?php
/** 
 * FACEBOOK LIKES IN LEARNINGSTUDIO
 *
 * @author    Jeof Oyster <jeof.oyster@pearson.com>
 * @partner   Brittney Cunningham <brittney.cunningham@asu.edu>
 * @copyright 2013 Pearson 
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version   1.0
 * @date      2013-11-11
 * 
 * Please refer to the License file provided with this sample application 
 * for the full terms and conditions, attributions, copyrights and license details.
 */
 
 
/* THIS FILE 
 * This file streamlines the OAuth 1.0 calls used to retrieve data via the 
 * the LearningStudio APIs. Note that it is *not* an authoritative example of 
 * how to make these calls. For a full detailed example in multiple languages 
 * please refer to the documentation in the PDN Portal: 
 * http://pdn.pearson.com/apis/authentication
 * http://pdn.pearson.com/pearson-learningstudio/apis/authentication/authentication-sample-code/sample-code-oauth-1a-php_x
 */



// Include the boostrap file from CryptLib. You can download this library from
// https://github.com/PearsonDevelopersNetwork/Library-CMAC-PHP. It's also a
// submodule in the FB Like Button Repository, so be sure to do a recursive clone when 
// checking out this sample application. 
require_once 'libraries/CryptLib/lib/CryptLib/bootstrap.php'; 




// This function streamlines GET requests to LearningStudio APIs. 
// Refer to documentation for a better example. 
// This function expects you have defined the API Keys in the 
// calling file: 
// $oauth_application_id
// $oauth_token_key_moniker
// $oauth_secret

function doLearningStudioGET($api_route){ 
    global $oauth_application_id, $oauth_token_key_moniker, $oauth_secret; 
    
    $api_hostname = 'https://m-api.ecollege.com'; 
    
    //Prep OAuth 1.0a Signature
    $oAuthVariables = array(); 
    $oAuthVariables['application_id'] = $oauth_application_id; 
    $oAuthVariables['oauth_consumer_key'] = $oauth_token_key_moniker; 
    $oAuthVariables['oauth_nonce'] = md5(microtime()); 
    $oAuthVariables['oauth_signature_method'] = 'CMAC-AES';
    $oAuthVariables['oauth_timestamp'] = time();

    $signable_string='GET'.'&'.urlencode(parse_url($api_route,PHP_URL_PATH)).'&'; 
    
    $StringParts = $oAuthVariables; 
    parse_str(parse_url($api_route,PHP_URL_QUERY), $query_array);	
    $StringParts = array_merge($StringParts,$query_array); 
    ksort($StringParts); 
    
    $encodable = array(); 
    foreach($StringParts as $key=>$value) $encodable[] = $key.'='.$value;
    $signable_string.=urlencode(implode('&',$encodable)); 

    $CMACEngine = new CryptLib\MAC\Implementation\CMAC;
    $packed_string = ''; 
    $stringlength = strlen($signable_string); 
    for($i=0; $i<$stringlength; $i++) $packed_string .= pack("c", ord(substr($signable_string, $i, 1))); 
    $signature = base64_encode($CMACEngine->generate($packed_string,$oauth_secret));

    $request_url_parts = parse_url($api_hostname.$api_route); 
    $header_vars = array('realm'=>$request_url_parts['scheme'].'://'.$request_url_parts['host'].$request_url_parts['path']); 
    $header_vars = array_merge($header_vars,$oAuthVariables); 
    $header_vars['oauth_signature'] = $signature; 
    $header_parts = array(); 
    foreach($header_vars as $k=>$v){ 
    	$v = ($k=='realm')?$v:urlencode($v); 
    	$header_parts[] = $k.'="'.$v.'"'; 
    } 
        
    // Execute Signed Request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_hostname.$api_route);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Authorization: OAuth ".implode(',',$header_parts))); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // local PHP deployments sometimes need this. Otherwise comment this out. 
    $api_response = curl_exec($ch);
    $curlError = curl_error($ch);
    $info = curl_getinfo($ch); 
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if($curlError){
	    return array('error'=>array('message'=>"There was a problem with cURL. The request was not sent to LearningStudio.","errorId"=>$curlError)); 
    } else {
        return json_decode($api_response); 
    }
} 


// This function decrypts an rc4-encoded string. The JavaScript 
// front-encrypts the course, user and content IDs into a hash so that 
// plain text IDs aren't obvious to everyday Facebook users. 

function rc4decrypt($key, $str) {
	$s = array();
	for ($i = 0; $i < 256; $i++) {
		$s[$i] = $i;
	}
	$j = 0;
	for ($i = 0; $i < 256; $i++) {
		$j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
		$x = $s[$i];
		$s[$i] = $s[$j];
		$s[$j] = $x;
	}
	$i = 0;
	$j = 0;
	$res = '';
	for ($y = 0; $y < strlen($str); $y++) {
		$i = ($i + 1) % 256;
		$j = ($j + $s[$i]) % 256;
		$x = $s[$i];
		$s[$i] = $s[$j];
		$s[$j] = $x;
		$res .= $str[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
	}
	return $res;
}
