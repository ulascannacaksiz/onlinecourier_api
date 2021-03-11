<?php
class SaveDb extends CI_Controller{
	public $data;
	public function __construct()
	{
		parent::__construct();
		$this->load->model("SaveToDB");
	}

	public function saveUsertoDB()
	{
		$json_contents = file_get_contents("php://input");
		$contents = json_decode($json_contents,true);
		if(!is_array($contents)){
			$contents = array();
		}
		$resultfromDB = $this->SaveToDB->saveUsertoDB($contents);
		return $resultfromDB;

	}

	public function saveCargotoDB()
	{
		$json_contents = file_get_contents("php://input");
		$contents = json_decode($json_contents,true);
		if(!is_array($contents)){
			$contents = array();
		}
		$resultfromDB = $this->SaveToDB->saveCargotoDB($contents);
		return $resultfromDB;
	}

	public function saveSubscribertoDB()
	{
		$json_contents = file_get_contents("php://input");
		$contents = json_decode($json_contents,true);
		if(!is_array($contents)){
			$contents = array();
		}
		$resultfromDB = $this->SaveToDB->saveSubscribertoDB($contents);
		return $resultfromDB;
	}


}
