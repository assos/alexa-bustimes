<?php

/********************************************************************************
 *																				*
 *	NAME:				LoggerModel												*
 *	TYPE:				Class													*
 *	DESCRIPTION:		Model containing logger functions						*
 *	ORIGINAL AUTHOR:	Daniel McGiff											*
 *	CONTRIBUTORS:																*
 *	DATE CREATED:		8th December 2018										*
 *	DATE MODIFIED:		8th December 2018										*
 *																				*
 ********************************************************************************/
 
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerModel extends CI_Model
{

	function addEntry($logger,$entry,$severity)
	{
	
		/********************************************************************************
		 *																				*
		 *	NAME:				addEntry												*
		 *	TYPE:				Function												*
		 *	DESCRIPTION:		Adds entry to log										*
		 *																				*
		 *	INPUTS:				logger (MonologLogger)									*
		 *						severity (string)										*
		 *																				*
		 *	ORIGINAL AUTHOR:	Daniel McGiff											*
		 *	CONTRIBUTORS:																*
		 *	DATE CREATED:		8th December 2018										*
		 *	DATE MODIFIED:		8th December 2018										*
		 *																				*
		 ********************************************************************************/

		switch($severity)
		{
			case "DEBUG":
			
				$logger->addDebug($entry);
			
			break;
			
			case "INFO":
				
				$logger->addInfo($entry);
			
			break;
			
			case "NOTICE":
			
				$logger->addNotice($entry);
			
			break;
			
			case "WARNING":
			
				$logger->addWarning($entry);
				
			break;
			
			case "ERROR":
			
				$logger->addError($entry);
				
			break;
			
			case "CRITICAL":
			
				$logger->addCritical($entry);
			
			case "ALERT":
				
				$logger->addAlert($entry);
				
			break;
			
			case "EMERGENCY":
			
				$logger->addAlert($entry);
				
			break;
		}
	}

	public function alexaRequestEntry($entry,$severity)
	{
		$logger = new Logger('alexaRequest');
		$logger->pushHandler(new StreamHandler(FCPATH . 'application/logs/alexaRequest.log',LOGGER::DEBUG));
		$this->addEntry($logger,$entry,$severity);
	}
	
	public function alexaResponseEntry($entry,$severity)
	{
		$logger = new Logger('alexaResponse');
		$logger->pushHandler(new StreamHandler(FCPATH . 'application/logs/alexaResponse.log',LOGGER::DEBUG));
		$this->addEntry($logger,$entry,$severity);
	}
	
	public function dbEntry($entry,$severity)
	{
		$logger = new Logger('db');
		$logger->pushHandler(new StreamHandler(FCPATH . 'application/logs/db.log',LOGGER::DEBUG));
		$this->addEntry($logger,$entry,$severity);
	}
}