<?php

/**
 * @author ben khssib khouloud
 * @MKIT e_learning
 */

require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['rep']) && isset($_POST['question'])) {

    // receiving the post params
    $rep = $_POST['rep'];
    $question = $_POST['question'];
	
        $reply = $db->storereplyofquiz($rep, $question);
        if ($reply) {
           
            $response["quiz"]["rep"] = $reply["rep"];
            echo json_encode($response);
        } else {
            // reply failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in store reply!";
            echo json_encode($response);
        }
}
    
 else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (rep , question) is missing!";
    echo json_encode($response);
}

?>

