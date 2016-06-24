<?php

require_once('db.php');
require_once('jsonHelper.php');

header('content-Type: application/json');

function main() {

	$data = JsonHelper::getJsonPostData();
	$db = new DBWrapper();

	// If parameters are invalid.
	if (!isset($data['start']) || !isset($data['count'])) {
		return JsonHelper::invalidParameterJson();
	}

	$start = trim($data['start']);
	$count = trim($data['count']);

	if ($start < 1) {
		$start = 1;
	}

	if ($count < 0) {
		$count = 5;
	}

	// This is cos sql offset parameter excludes offset and start from offset + 1;
	$offset = $start - 1;

	// There is some connection error. We return the connection error.
	if ($db->connect() == false) {
		return JsonHelper::dbConnectionErrorJson($db->connectionError());
	}
	
	$arr = array();
	$query = sprintf("SELECT * FROM BlogTable ORDER BY timestamp DESC, id DESC LIMIT ".$count." OFFSET ".$offset." ");
	$blogs = $db->query($query);

	$blogsarray = array();
	
	if ($blogs == false) {
		// If this is false, some transaction error has occured. 
		$db->disconnect();
		return JsonHelper::dbTansactErrorJson($db->error());
	} else if ($blogs == -1) {
		// Query was successful. But no rows returned.
		$blogsarray = [];
	} else {
		for ($i = 0; $i < count($blogs); $i++) {
			$blog = $blogs[$i];

			$query = sprintf("SELECT * FROM ParaTable WHERE blogid = ".$blog['id']." ORDER BY parano ASC ");
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

			$blogarray = array("blogid"=>$blog['id'], "blogtitle" =>$blog['title'], "paras" =>$parasarray);
			$blogsarray[$i] = $blogarray;
		}

	}

	$db->disconnect();
	$response = array("start" => $start, "count" => $count, "blogs" => $blogsarray);
	return JsonHelper::successJson($response, true);
}

print main();
	
?>