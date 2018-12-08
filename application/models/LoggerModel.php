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

	function addEntry($logger,$severity)
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
		$logger->pushHandler(new StreamHandler(FCPATH . '/alexaRequest.log',LOGGER::DEBUG));
		addEntry($logger,$severity);
	}
}