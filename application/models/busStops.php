<?php

class busStops_model extends CI_Model
{
	public function fetchNearbyStops()
	{
		$this->load->model('transportAPI');
		$this->transportAPI->placesJSON();
	}
}