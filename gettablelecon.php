<?php

/**
 * @author ben khssib khouloud
 * @MKIT e_learning
 */

require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['id_chap'])){
    // receiving the post params
    $id_chap = $_POST['id_chap'];

    // get the chapiters by id_cour
    $lecon = $db->getAlllessons($id_chap);

    if ($lecon != false) {
        // use is found
        $response["error"] = FALSE;
        $response["id_lec"] = $lecon["id_lec"];
        $response["lecon"]["titre_lec"] = $lecon["titre_lec"];
		$response["lecon"]["url_video_lec"] = $lecon["url_video_lec"];
        $response["lecon"]["description_lec"] = $lecon["description_lec"];
		$response["lecon"]["id_chap"] = $lecon["id_chap"];
	  
        echo json_encode($response);
    } else {
        // lessons are not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Get all tables are wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters id_chap is missing!";
    echo json_encode($response);
}
?>

