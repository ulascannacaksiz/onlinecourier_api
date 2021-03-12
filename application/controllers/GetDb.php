<?php
class GetDb extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("GetFromDb");
		$this->load->model("GeneralModel");
	}

	public function getUserfromDB()
	{
		$json_contents = file_get_contents("php://input");
		$contents = json_decode($json_contents,true);
		if(!is_array($contents)){
			$rulesforquery = array();
		} else{
			$rulesforquery = $contents;
		}
		$resultfromDB = $this->GetFromDb->getUserfromDB($contents);
		echo json_encode($resultfromDB);

	}

	public function getCargofromDb()
	{
		$json_contents = file_get_contents("php://input");
		$contents = json_decode($json_contents,true);
		$is_numeric = null;
		if(!is_array($contents)){
			$rulesforquery = array();
		} else{
			$rulesforquery = $contents;
			$is_numeric = $rulesforquery["is_numeric"];
			unset($rulesforquery["is_numeric"]);
		}

		$resultfromDB = $this->GeneralModel->getResultfromDB($rulesforquery,"cargo",$is_numeric);


		echo json_encode($resultfromDB);

	}

	public function getCityfromDb(){
		$json_contents = file_get_contents("php://input");
		$contents = json_decode($json_contents,true);
		$is_numeric = null;
		if(!is_array($contents)){
			$rulesforquery = array();
		} else{
			$rulesforquery = $contents;
			$is_numeric = $rulesforquery["is_numeric"];
			unset($rulesforquery["is_numeric"]);
		}

		$resultfromDB = $this->GeneralModel->getResultfromDB($rulesforquery,"city",$is_numeric);


		echo json_encode($resultfromDB);
	}

	public function getDistrictfromDb(){
		$json_contents = file_get_contents("php://input");
		$contents = json_decode($json_contents,true);
		$is_numeric = null;
		if(!is_array($contents)){
			$rulesforquery = array();
		} else{
			$rulesforquery = $contents;
			$is_numeric = $rulesforquery["is_numeric"];
			unset($rulesforquery["is_numeric"]);
		}

		$resultfromDB = $this->GeneralModel->getResultfromDB($rulesforquery,"district",$is_numeric);


		echo json_encode($resultfromDB);
	}


}
