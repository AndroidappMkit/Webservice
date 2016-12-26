<?php

/**
 * @author ben khssib khouloud
 * @MKIT e_learning
 */

require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['id_cour'])){
    // receiving the post params
    $id_cour = $_POST['id_cour'];

    // get the chapiters by id_cour
    $chapitre = $db->getAllchapitres($id_cour);

    if ($chapitre != false) {
        // use is found
        $response["error"] = FALSE;
        $response["id_chap"] = $chapitre["id_chap"];
        $response["chapitre"]["titre_chap"] = $chapitre["titre_chap"];
        $response["chapitre"]["description_chap"] = $chapitre["description_chap"];
		$response["chapitre"]["id_cour"] = $chapitre["id_cour"];
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

