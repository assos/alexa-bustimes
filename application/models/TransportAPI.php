<?php

/****************************************************************************
 *																			*
 *	NAME:				transportAPI_model									*
 *	TYPE:				Class												*
 *	DESCRIPTION:		Implementation of https://www.transportapi.com/		*
 *	ORIGINAL AUTHOR:	Daniel McGiff										*
 *	CONTRIBUTORS:															*
 *	DATE CREATED:		6th December 2018									*
 *	DATE MODIFIED:		6th December 2018									*
 *																			*
 ****************************************************************************/
 
class TransportAPI extends CI_Model
{
	public $app_id = '4afb0307';
	public $app_key = '43a5d60aabe4d13f753eb9fed9b898f6';
	
	public function placesJSON($type,$lat = null,$lon = null,$max_lat = null,$max_lon = null,$min_lat = null,$min_lon = null,$query = null)
	{
		/****************************************************************************************************************************************
		 *																																		*
		 *	NAME: 			placesJSON																											*
		 *	TYPE:			Function																											*
		 *	DESCRIPTION: 	Implements transportAPI /uk/places.json endpoint.																	*
		 *																																		*
		 *	INPUTS:			type (string)																										*
		 *						A type or comma separated set of types to limit the search results to. The default is to match on all types. 	*
		 *						The set of possible match types are currently as follows:														*
		 *							-	train_station																							*
		 *							-	bus_stop																								*
		 *							-	settlement																								*
		 *							-	region																									*
		 *							-	street																									*
		 *							-	poi																										*
		 *							-	postcode																								*
		 *					lat (number)																										*
		 *						Latitude for the focal point of a geographic nearby search														*
		 *					lon (number)																										*
		 *						Longitude for the focal point of a geographic nearby search														*
		 *					max_lat (number)																									*
		 *						Maximum latitude for a geographic bounding-box search															*
		 *					max_lon (number)																									*
		 *						Maximum longitude for a geographic bounding-box search															*
		 *					min_lat (number)																									*
		 *						Minimum latitude for a geographic bounding-box search															*
		 *					min_lon (number)																									*
		 *						Minimum longitude for a geographic bounding-box search															*
		 *					query (string)																										*
		 *						Query text for performing a text matching search.																*
		 *																																		*
		 *	RETURNS:		Object containing request_time (timestamp), source (string), acknowledgements (string), member (array)				*
		 *						member (array) contains objects structured as follows															*
		 *							type (string) 																								*
		 *								A short type identifying what type of result this is. Possible values as per type input					*
		 *							name (string)																								*
		 *								A short name for the search match, suitable for prominent display, 										*
		 *								however it may not be unique within the result set. 													*
		 *								For postcodes, this is a cleaned up version of the postcode 											*
		 *								(capitalised and with a space inserted at the normal place												*
		 *							description (string)																						*
		 *								A longer textual description providing extended information												*
		 *							latitude (number)																							*
		 *								latitude of the place. 																					*
		 *								Accuracy of positioning will vary depending on the type (and data source used for that type). 			*
		 *								For wide area places such as settlements these coordinates will be placed centrally						*
		 *							longitude (number)																							*
		 *								longitude of the place.																					*
		 *								Accuracy of positioning will vary depending on the type (and data source used for that type).			*
		 *								For wide area places such as settlements these coordinates will be placed centrally						*
		 *							accuracy (number)																							*
		 *								A radius (in metres) of accuracy for the geocoding.														*
		 *							distance (number)																							*
		 *								The distance in metres from the specified focal point. 													*
		 *								Optional field only present when a focal point is specified												*
		 *							atcocode (string)																							*
		 *								Bus stop identifier Returned only for type=bus_stop and type=tube_station matches						*
		 *							station_code (string)																						*
		 *								3-Alpha code for the station Returned only for type=train_station matches								*
		 *							tiploc_code (string)																						*
		 *								Unique TIPLOC station codes. Returned only for type=train_station matches								*
		 *							osm_id (string)																								*
		 *								The OpenStreetMap element type ('node'/'way'/'relation') followed by a colon ':' char 					*
		 *								followed by the OpenStreetMap numeric id if the object.													*
		 *																																		*
		 ****************************************************************************************************************************************/			
		 
		 $url = "http://transportapi.com/v3/uk/places.json?app_key=$this->app_key&app_id=$this->app_id";
		 echo $url;
		 die();
	}
}

?>
