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
		$raw_input_str = $this->input->raw_input_stream;
		$arr_input_str = print_r($this->input->input_stream(),true);
		
		$this->load->model('LoggerModel');
		
		$this->LoggerModel->alexaRequestEntry(file_get_contents('php://input'));
		$this->LoggerModel->alexaRequestEntry(json_decode($raw_input_str),'DEBUG');
		$this->LoggerModel->alexaRequestEntry($arr_input_str,'DEBUG');
		
	}
}