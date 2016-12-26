<?php

/**
 * @author ben khssib khouloud
 * @MKIT e_learning
 */

require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['id_lec'])){
    // receiving the post params
    $id_lec = $_POST['id_lec'];

    // get the quiz by id_cour
    $quiz = $db->getAllquiz($id_lec);

    if ($quiz != false) {
        // quiz is found
        $response["error"] = FALSE;
        $response["id_quiz"] = $chapitre["id_quiz"];
        $response["quiz"]["question"] = $quiz["question"];
		$response["quiz"]["rep"] = $quiz["rep"];
		$response["quiz"]["choix_a"] = $quiz["choix_a"];
		$response["quiz"]["choix_b"] = $quiz["choix_b"];
		$response["quiz"]["choix_c"] = $quiz["choix_c"];
		$response["quiz"]["bonne_rep"] = $quiz["bonne_rep"];
		$response["quiz"]["id_lec"] = $chapitre["id_lec"];
        echo json_encode($response);
    } else {
        // chapitres are not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Get all tables are wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters id_cour is missing!";
    echo json_encode($response);
}
?>

