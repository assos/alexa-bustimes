<?php

class BusStopModel extends CI_Model
{
	public function fetchNearbyStops()
	{
		$this->load->model('transportAPI');
		$this->transportAPI->placesJSON();
	}
}