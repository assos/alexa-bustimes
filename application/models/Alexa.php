<?php

/********************************************************************************
 *																				*
 *	NAME:				Alexa													*
 *	TYPE:				Class													*
 *	DESCRIPTION:		Model containing functions for interacting with Alexa	*
 *	ORIGINAL AUTHOR:	Daniel McGiff											*
 *	CONTRIBUTORS:																*
 *	DATE CREATED:		7th December 2018										*
 *	DATE MODIFIED:		7th December 2018										*
 *																				*
 ********************************************************************************/
 
class Alexa extends CI_Model
{
	public function securityCheck()
	{
		$raw_input_str = $this->input->raw_input_stream;
		$arr_input_str = print_r($this->input->input_stream(),true);
		
		$this->load->helper('file');

		write_file('./raw.txt',$raw_input_str);
		write_file('./arr.txt',$arr_input_str);
	}
}