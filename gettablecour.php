<?php

/**
 * @author ben khssib khouloud
 * @MKIT e_learning
 */

require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['id'])){
    // receiving the post params
    $id = $_POST['id'];

    // get the cour
    $cour = $db->getAllCourses($id);

    if ($cour != false) {
        // use is found
        $response["error"] = FALSE;
        $response["id_cour"] = $cour["id"];
        $response["cour"]["libelle_cour"] = $cour["libelle_cour"];
		 $response["cour"]["id"] = $cour["id"];
        echo json_encode($response);
    } else {
        // cour is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Get table cour is wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters id user is missing!";
    echo json_encode($response);
}
?>

