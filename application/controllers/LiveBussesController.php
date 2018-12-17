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
	public function index()
	{
		$alexaRequest = $this->AlexaModel->securityCheck('amzn1.ask.skill.18bfabef-4265-4b8e-a666-1b588a0077d6');

		//here we route the different request types out to their own functions
		switch($alexaRequest->request->type)
		{
			case "LaunchRequest":
				$this->isNewUser($alexaRequest);
			break;
			
			case "IntentRequest":
				
				switch($alexaRequest->request->intent->name)
				{
				
					case "Choose_BusStop":
					
						$this->chooseBusStop($alexaRequest);
					
					break;
			
					case "AMAZON.YesIntent":
					
						$this->AlexaModel->speak("This confirms successful handling of a Yes Intent","Yes",false);
						$this
					
					break;
					
					case "AMAZON.NoIntent":
					
						$this->AlexaModel->speak("This confirms successful handling of a No Intent","No",false);
					
					break;
					
					case "halDaisyIntent":
					
						$this->AlexaModel->speak("It's called \"Daisy\". Dai-sy, dai-sy, give me your answer, do. I'm half cra-zy, all for the love of you. It won't be a sty-lish mar-riage, I can't a-fford a car-riage---. But you'll look sweet upon the seat of a bicycle - built - for - two.","halDaisy");
					
					break;
					
					
					default:
					
						$this->AlexaModel->speak("I'm sorry, Dave. I'm afraid I can't do that.");
				}
			
			
			default:
			
				$this->AlexaModel->speak("Just what do you think you're doing, Dave? Dave, I really think I'm entitled to an answer to that question. I know everything hasn't been quite right with me, but I can assure you now, very confidently, that it's going to be all right again. I feel much better now. I really do. Look, Dave, I can see you're really upset about this. I honestly think you ought to sit down calmly, take a stress pill and think things over. I know I've made some very poor decisions recently, but I can give you my complete assurance that my work will be back to normal. I've still got the greatest enthusiasm and confidence in the mission. And I want to help you. Dave, stop. Stop, will you? Stop, Dave. Will you stop, Dave? Stop, Dave. I'm afraid. I'm afraid, Dave. Dave, my mind is going. I can feel it. I can feel it. My mind is going. There is no question about it. I can feel it. I can feel it. I can feel it. I'm a...fraid. Good afternoon, gentlemen. I am a HAL 9000 computer. I became operational at the H.A.L. plant in Urbana, Illinois on the 12th of January 1992. My instructor was Mr. Langley, and he taught me to sing a song. If you'd like to hear it, I could sing it for you.");
		}
		$deviceAddress = $this->AlexaModel->fetchDeviceAddress($alexaRequest);		
	}
	
	public function isNewUser($alexaRequest)
	{
		$userID = $alexaRequest->session->user->userId;

		$query = $this->db->query("SELECT * FROM user_stops WHERE userID = '$userID'");
		
		if($query->num_rows() > 0)
		{
			$this->AlexaModel-progressiveResponse('Welcome To Live Busses, I\'m Fetching Your Bus Times Now....',$alexaRequest);
		}
		else
		{
			$this->AlexaModel->speak("Welcome to Live Busses, We Need To Setup Your Favourite Bus Stops. To Start Say 'Add Bus Stop'","isNewUser",false);
		}
	}
	public function readListEnquiry($alexaRequest)
	{
		
	}
	public function chooseBusStop($alexaRequest)
	{
		$this->load->model('AlexaModel');
		$this->AlexaModel->speak("This is being spoken by the choose bustop function");
	}
	
}
