<?php

require_once('db.php');
require_once('jsonHelper.php');

header('content-Type: application/json');

function main() {

	$data = JsonHelper::getJsonPostData();
	$db = new DBWrapper();

	// If parameters are invalid.
	if (!isset($data['blogid'])) {
		return JsonHelper::invalidParameterJson();
	}

	$blogid = trim($data['blogid']);

	if (empty($blogid)) {
		return JsonHelper::invalidParameterJson();
	}

	// There is some connection error. We return the connection error.
	if ($db->connect() == false) {
		return JsonHelper::dbConnectionErrorJson($db->connectionError());
	}
	
	$query = sprintf("SELECT * FROM BlogTable where id = ".$blogid);
	$blogs = $db->query($query);
	$blog = $blogs[0];

	if ($blog == false || $blog == -1) {
		// If this is false, some transaction error has occured. 
		$db->disconnect();
		return JsonHelper::dbTansactErrorJson($db->error());
	} else {
		$query = sprintf("SELECT * FROM ParaTable WHERE blogid = ".$blogid." ORDER BY parano ASC ");
		$paras = $db->query($query);
		$parasarray = array();
		
		if ($paras == false) {
			$db->disconnect();
			return JsonHelper::dbTansactErrorJson($db->error());
		} else if ($paras == -1) {
			// Query was successful. But no row returned.
			$parasarray = [];
		} else {
			for ($j = 0; $j < count($paras); $j++) {
				$para = $paras[$j];
				$query = sprintf("SELECT * FROM CommentTable WHERE paraid = ".$para['id']." ");
				$comments = $db->query($query, $arr);

				if ($comments == false) {
					$db->disconnect();
					return JsonHelper::dbTansactErrorJson($db->error());
				} else if ($comments == -1) {
					// Query was successful. But no results returned.
					$comments = [];
				}

				$paraarray = array("paraid"=>$para['id'], "parano"=>$para['parano'], "paratext"=>$para['paratext'], "comments" =>$comments);
				$parasarray[$j] = $paraarray;
			}
		}

		$db->disconnect();
		$response = array("blogid"=>$blog['id'], "blogtitle" =>$blog['title'], "paras" =>$parasarray);
		return JsonHelper::successJson($response, true);
	}
}

print main();
	
?>