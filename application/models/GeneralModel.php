<?php
class GeneralModel extends CI_Model
{
	public $data;

	public function __construct()
	{
		parent::__construct();
	}

	public function getResultfromDB($rulesforquery, $tablename, $is_numeric = null)
	{
		$this->setTablename($tablename);
		$return_result = $this->executeQueryandgetResult($rulesforquery, $is_numeric);
		return $return_result;
	}

	private function executeQueryandgetResult($rulesforquery, $is_numeric)
	{
		if(!array_key_exists("insert",$rulesforquery) || !array_key_exists("update",$rulesforquery)){
			$executed_query = $this->db->select("*")->from($this->getTablename());
		}
		if(array_key_exists("join_type",$rulesforquery)){
			$join_type = $rulesforquery["join_type"];
		}
		foreach ($rulesforquery as $rule_key => $rule_value) {
			switch ($rule_key) {
				case "like" :
					foreach ($rule_value as $rv_key => $rv_value) {
						$executed_query = $executed_query->like($rv_key, $rv_value);
					}
					break;
				case "where" :
					$executed_query = $executed_query->where($rule_value);
					break;
				case "join" :
					foreach ($rule_value as $join_tablename => $join_rule) {
						$executed_query = $executed_query->join($join_tablename, $join_rule, $join_type);
					}
					break;
				case "insert":
					$this->db->insert($this->getTablename(), $rule_value);
					break;
				case "update":
					$this->db->update($this->getTablename(), $rule_value);
					break;
			}
		}

		if (array_key_exists("limit", $rulesforquery) && array_key_exists("start", $rulesforquery)) {
			$executed_query = $executed_query->limit($rulesforquery["limit"], $rulesforquery["start"]);
		}
		if (array_key_exists("col", $rulesforquery) && array_key_exists("dir", $rulesforquery)) {
			$executed_query = $executed_query->order_by($rulesforquery["col"], $rulesforquery["dir"]);
		}

		if (array_key_exists("update", $rulesforquery) || array_key_exists("insert", $rulesforquery)) {
			return $is_numeric == null ? $this->get_affected_rows_query_result() :
				$this->get_affected_rows();
		} else {
			$executed_query = $executed_query->get();
			return $is_numeric == null ? $this->get_numrows_query_result($executed_query) :
				$this->get_numrows($executed_query);
		}
	}

	private function get_numrows_query_result($executed_query)
	{
		$return_result = null;
		if ($executed_query->num_rows() > 0) {
			$return_result = $this->get_result_array($executed_query->result(), 200, null);
		} else {
			$return_result = $this->get_result_array(null, 404, "Error! Not Found");
		}
		return $return_result;
	}

	private function get_numrows($executed_query)
	{
		return $executed_query->num_rows();
	}

	private function get_affected_rows()
	{
		return $this->db->affected_rows();
	}

	private function get_affected_rows_query_result()
	{
		$return_result = null;
		if ($this->db->affected_rows() > 0) {
			$return_result = $this->get_result_array($this->db->insert_id(), 200, null);
		} else {
			$return_result = $this->get_result_array(null, 404, "Error! Not Found");
		}
		return $return_result;
	}

	private function get_result_array($data, $response_code, $error)
	{
		return array(
			"result" . $this->getTablename() => array(
				"result" => $data,
				"response_code" => $response_code,
				"error" => $error
			)
		);
	}

	private function setTablename($tablename)
	{
		$this->data["tablename"] = $tablename;
	}

	private function getTablename()
	{
		return $this->data["tablename"];
	}
}
