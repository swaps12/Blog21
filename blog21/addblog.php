<?php

require_once('db.php');	
require_once('jsonHelper.php');

header('content-Type: application/json');



function main() {

	$data = JsonHelper::getJsonPostData();

	// If parameters are invalid.
	if (!isset($data['title']) || !isset($data['blog'])) {
		return JsonHelper::invalidParameterJson();
	}
	
	$title = trim($data['title']);
	$blog = trim($data['blog']);

	// Check if the title and blog is non empty.
	if (empty($title) || empty($blog)) {
		return JsonHelper::invalidParameterJson();
	}

	$db = new DBWrapper();

	// There is some connection error. We return the connection error.
	if ($db->connect() == false) {
		return JsonHelper::dbConnectionErrorJson($db->connectionError());
	}

	// Insert the title. Get the title ID. Then insert the para.
	$query = sprintf("INSERT into BlogTable (title) value (?)");
	$data = array("s", $title);

	// The returned ID will help us insert separated paras.
	$id = $db->insert($query, $data);

	// Some error occured in the insert query.
	if ($id == false || $id == -1) {
		$db->disconnect();
		return JsonHelper::dbTansactErrorJson($db->error());
	}

	if ($id) {
		$paras = explode('\n\n', $blog);
		for ($i=0; $i < count($paras) ; $i++){

			// Insert para for the blog.
			$query =  sprintf("INSERT into ParaTable (paratext, blogid, parano) value (?, ?, ?)");
			$data = array("sii", $paras[$i], $id, ($i + 1));
			$result = $db->insert($query, $data);

			if ($result == false || $result == -1) {

				//Since adding para failed. We need to delete the recently added blog entry
				//to maintain sanity. Also we need to delete if any of the paras 
				//where of this blog is already added. We will not check for error condition in these
				// request as there isnt much we can do if this request fails.
				$query = sprintf("DELETE from ParaTable where blogid = ".$id);
				$db->query($query);

				$query = sprintf("DELETE from BlogTable where id = ".$id);
				$db->query($query);

				$db->disconnect();
				return JsonHelper::dbTansactErrorJson($db->error());
			}
		}
		$db->disconnect();
		return JsonHelper::successJson(NULL, false);
	}
	
}

print main();

?>

