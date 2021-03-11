<?php
class GetDb extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("GetFromDb");
	}

	public function getUserfromDB()
	{
		$json_contents = file_get_contents("php://input");
		$contents = json_decode($json_contents,true);
		if(!is_array($contents)){
			$contents = array();
		}
		$resultfromDB = $this->GetFromDb->getUserfromDB($contents);
		return $resultfromDB;

	}

	public function getCargofromDb()
	{
		$json_contents = file_get_contents("php://input");
		$contents = json_decode($json_contents,true);
		if(!is_array($contents)){
			$contents = array();
		}
		$resultfromDB = $this->GetFromDb->getCargofromDb($contents);
		return $resultfromDB;

	}
}
