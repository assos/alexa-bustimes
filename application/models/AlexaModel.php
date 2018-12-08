<?php

/********************************************************************************
 *																				*
 *	NAME:				AlexaModel												*
 *	TYPE:				Class													*
 *	DESCRIPTION:		Model containing functions for interacting with Alexa	*
 *	ORIGINAL AUTHOR:	Daniel McGiff											*
 *	CONTRIBUTORS:																*
 *	DATE CREATED:		7th December 2018										*
 *	DATE MODIFIED:		7th December 2018										*
 *																				*
 ********************************************************************************/
 
class AlexaModel extends CI_Model
{
	public function securityCheck()
	{
		$inputArr = json_decode($this->input->raw_input_stream);
		
		$applicationID = $inputArr->session->application->applicationId;
		
		$this->load->model('LoggerModel');
		
		$this->LoggerModel->alexaRequestEntry(print_r($inputArr->request,TRUE),'DEBUG');
		$this->LoggerModel->alexaRequestEntry('Application ID: ' . $applicationID,'DEBUG');

		switch($applicationID)
		{
			default:
			
				header ('Content-Type: application/json');
				$responseArr = array();
				$responseArr['version'] = '1.0';
				$responseArr['response'] = array();
				$responseArr['response']['outputSpeech'] = array();
				$responseArr['response']['outputSpeech']['type'] = 'PlainText';
				$responseArr['response']['outputSpeech']['text'] = 'Hmm... Do I know you?';
				echo json_encode($responseArr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		}
		
	}
}