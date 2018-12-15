<?php

/********************************************************************************
 *																				*
 *	NAME:				AlexaModel												*
 *	TYPE:				Class													*
 *	DESCRIPTION:		Model containing functions for interacting with Alexa	*
 *	ORIGINAL AUTHOR:	Daniel McGiff											*
 *	CONTRIBUTORS:																*
 *	DATE CREATED:		7th December 2018										*
 *	DATE MODIFIED:		9th December 2018										*
 *																				*
 ********************************************************************************/
 
class AlexaModel extends CI_Model
{

	function valid_cert($jsonRequest) 
	{
		/********************************************************************************	
		 *																				*
		 *	NAME: 			valid_cert													*
		 *	TYPE:			Function													*
		 *	DESCRIPTION: 	Validates Alexa SSL Cert from Request.						*
		 *																				*
		 *	ORIGINAL AUTHOR:	rbowen (https://github.com/rbowen)						*
		 *	TAKEN FROM:			https://github.com/rbowen/validate-echo-request-php		*		
		 *																				*
		 *	INPUTS:				jsonRequest (string) (required)							*
		 *																				*
		 ********************************************************************************/

		$data = json_decode($jsonRequest,true);
		$ECHO_CERT_CACHE = FCPATH . 'application/cache/';
				 																
	    // Determine if we need to download a new Signature Certificate Chain from Amazon
    	$md5pem = $ECHO_CERT_CACHE . md5($_SERVER['HTTP_SIGNATURECERTCHAINURL']) . '.pem';
		$echoServiceDomain = 'echo-api.amazon.com';

	    // If we haven't received a certificate with this URL before,
    	// store it as a cached copy
	    if (!file_exists($md5pem))
	    {
        	file_put_contents($md5pem, file_get_contents($_SERVER['HTTP_SIGNATURECERTCHAINURL']));
    	}

	    // Validate certificate chain and signature
    	$pem = file_get_contents($md5pem);
		$ssl_check = openssl_verify( $jsonRequest, base64_decode($_SERVER['HTTP_SIGNATURE']), $pem, 'sha1' );
		if ($ssl_check != 1) 
		{
			$this->LoggerModel->alexaRequestEntry('Certificate Verification Failed: ' . openssl_error_string(),'NOTICE');
			return false;
    	}

		// Parse certificate for validations below
    	$parsedCertificate = openssl_x509_parse($pem);
    	if (!$parsedCertificate) 
    	{
			$this->LoggerModel->alexaRequestEntry('Certificate Verification Failed: x509 Parsing Failure','NOTICE');
			return false;
    	}

		// Check that the domain echo-api.amazon.com is present in
    	// the Subject Alternative Names (SANs) section of the signing certificate
    	if(strpos( $parsedCertificate['extensions']['subjectAltName'],$echoServiceDomain) === false) 
    	{
			$this->LoggerModel->alexaRequestEntry('Certificate Verification Failed: subjectAltName Check Failed','NOTICE');
			return false;
    	}

	    // Check that the signing certificate has not expired
    	// (examine both the Not Before and Not After dates)
	    $validFrom = $parsedCertificate['validFrom_time_t'];
    	$validTo = $parsedCertificate['validTo_time_t'];
		$time = time();
		
		if (!($validFrom <= $time && $time <= $validTo)) 
		{
			$this->LoggerModel->alexaRequestEntry('Certificate Verification Failed: Expiration Check Failed','NOTICE');
			return false;
    	}

		return true;
	}
	
	public function securityCheck($skillID)
	{
		$inputRaw = $this->input->raw_input_stream;
		$inputArr = json_decode($inputRaw);
		
		$applicationID = $inputArr->session->application->applicationId;
		$requestTimestamp = $inputArr->request->timestamp;
		$signatureCertChainURL = $_SERVER['HTTP_SIGNATURECERTCHAINURL'];

		$this->load->model('LoggerModel');
		
		$this->LoggerModel->alexaRequestEntry(print_r($inputArr->request,TRUE),'DEBUG');
		$this->LoggerModel->alexaRequestEntry('Application ID: ' . $applicationID,'DEBUG');
		$this->LoggerModel->alexaRequestEntry('Request Certificate URL: ' . $signatureCertChainURL,'DEBUG');

		//First Security Check - Does the ApplicationID passed in the request match the SkillID passed in the function call.
		if($skillID != $applicationID)
		{
			$securityFailed = true;
			$this->LoggerModel->alexaRequestEntry('Invalid application ID. Passed ' . $applicationID . ' expecting ' . $skillID,'NOTICE');
		}

		//Second Security Check - Is the timestamp valid?
		if($requestTimestamp <= date('Y-m-d\TH:i:s\Z', time()-150))
		{
			$securityFailed = true;
			$this->LoggerModel->alexaRequestEntry('Invalid request timestamp' . $requestTimestamp,'NOTICE');
		}
		
		//Third Security Check - Is the Certificate Valid?
		if(!$this->valid_cert($inputRaw))
		{
			$securityFailed = true;
		}
		
		if($securityFailed)
		{
			$this->speak("Hmmm... Do I know you");
		}
		else
		{
			$this->LoggerModel->alexaRequestEntry('Security Checks Passed','INFO');
			return $inputArr;
		}
		
	}
	public function speak($textToSpeak,$endSession = true)
	{
		$this->load->model('LoggerModel');

		header ('Content-Type: application/json');
		$responseArr = array();
		$responseArr['version'] = '1.0';
		$responseArr['response'] = array();
		$responseArr['response']['outputSpeech'] = array();
		$responseArr['response']['outputSpeech']['type'] = 'PlainText';
		$responseArr['response']['outputSpeech']['text'] = $textToSpeak;
		if($endSession != true)
		{
			$responseArr['response']['shouldEndSession'] = $endSession;
		}
		$responseToOutput = json_encode($responseArr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		
		echo $responseToOutput;
		$this->LoggerModel->alexaResponseEntry($responseToOutput,'DEBUG');
		die();
	}
	public function fetchDeviceAddress($inputArr)
	{
		$this->load->model('LoggerModel');

		$deviceID = $inputArr->context->System->device->deviceId;
		$apiToken = $inputArr->context->System->apiAccessToken;

		$this->LoggerModel->alexaRequestEntry('Device ID: ' . $deviceID,'DEBUG');
		$this->LoggerModel->alexaRequestEntry('API Token: ' . $apiToken,'DEBUG');
		
		$url = "https://api.amazonalexa.com/v1/devices/$deviceID/settings/address";
		
		$this->LoggerModel->alexaRequestEntry('Request URL: ' . $url,'DEBUG');
		
		$response = \Httpful\Request::get($url)
			->addHeader('Authorization', 'Bearer ' . $apiToken)
			->send();
		
		$this->LoggerModel->alexaRequestEntry(print_r($response->body,TRUE),'DEBUG');
		
		return $response->body;
	}
}