<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LiveBussesController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function LaunchSkill()
	{
		$this->load->model('AlexaModel');
		$alexaRequest = $this->AlexaModel->securityCheck('amzn1.ask.skill.18bfabef-4265-4b8e-a666-1b588a0077d6');

		//here we route the different request types out to their own functions
		switch($alexaRequest->request->type)
		{
			case: "LaunchRequest":
				$this->AlexaModel->speak("Welcome to Live Busses");
			break;
			
			default:
			
				$this->AlexaModel->speak("I'm sorry, I can't help with that yet...");
		}
		$deviceAddress = $this->AlexaModel->fetchDeviceAddress($alexaRequest);		
	}
}
