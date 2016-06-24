<?php

require_once('db.php');
require_once('jsonHelper.php');

header('content-Type: application/json');
/* The data passes to this api will be in the following format.
 * {"blogid" : 1
 	"comments": [{"paraid" : 1, "commnent": "This is temp comment"} , {"paraid" : 4, "commnent": "This is temp comment"}]}
 */

 // First we parse the Post parameters to retrieve the data.

function main() {
	
	$data = JsonHelper::getJsonPostData();

	// If parameters are invalid.
	if (!isset($data['blogid']) || !isset($data['comments'])) {
		return JsonHelper::invalidParameterJson();
	}
	
	$blogid = trim($data['blogid']);
	$comments = $data['comments'];

	// Check if the title and blog is non empty.
	if (empty($blogid) || empty($comments)) {
		printf("Hello Again\n");
		return JsonHelper::invalidParameterJson();
	}

	$db = new DBWrapper();

	// There is some connection error. We return the connection error.
	if ($db->connect() == false) {
		return JsonHelper::dbConnectionErrorJson($db->connectionError());
	}

	foreach ($comments as $comment) {
		$commenttext = trim($comment['comment']);
		$paraid = trim($comment['paraid']);

		if (!empty($paraid) && !empty($commenttext)) {

			$query = sprintf("INSERT into CommentTable (comment, paraid) value (?,?)");
			$data = array("si", $commenttext, $paraid);
			$id = $db->insert($query, $data);

			if ($id == false || $id == -1) {
				printf("Error occured for %s", $commenttext);
				// We chose not to do nething here as other comment insertion is atomic
				// Hence we continue with the loop inspite of the error.
				//$db->disconnect();
				//return JsonHelper::dbTansactErrorJson($db->error());
			}
		}
	}

	$db->disconnect();
	return JsonHelper::successJson(NULL, false);
	
}

print main();

?>