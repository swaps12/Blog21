<?php

const INVALID_PARAMETER_ERRORCODE = '404';
const INVALID_PARAMETER_ERRORMSG = 'Invalid Post Parameters';
const SUCCESS_CODE = '200';
const SUCCESS_MSG = 'Success';
const DB_TRANSACTION_ERROR_CODE = '2012';
const DB_CONNECT_ERROR_CODE = '2021';


class JsonHelper {

	static public function getJsonPostData() {
		return json_decode(file_get_contents('php://input'), true);
	}

	static public function invalidParameterJson() {
		$response = array("Status" => INVALID_PARAMETER_ERRORCODE, "Message" => INVALID_PARAMETER_ERRORMSG);
		return json_encode($response);
	}

	static public function successJson($data, $sendData) {
		if ($sendData) {
			$response = array("Status" => SUCCESS_CODE, "Message" =>SUCCESS_MSG, "data" => $data);
			return json_encode($response);
		} else {
			$response = array("Status" => SUCCESS_CODE, "Message" =>SUCCESS_MSG);
			return json_encode($response);
		}
	}

	static public function dbTansactErrorJson($error) {
		$errormsg = "Database Transaction Failed. Error:".$error;
		$response = array("Status" => DB_TRANSACTION_ERROR_CODE, "Message" =>$errormsg);
		return json_encode($response);
	}

	static public function dbConnectionErrorJson($error) {
		$errormsg = "Database Connection Failed. Error:".$error;
		$response = array("Status" => DB_CONNECT_ERROR_CODE, "Message" =>$errormsg);
		return json_encode($response);
	}
}

?>