<?php

/**
 * @author ben khssib khouloud
 * @MKIT e_learning
 */

require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['unique_id'])) {
    // receiving the post params
    $unique_id = $_POST['unique_id'];

    // get the user by email and password
    $user = $db->getUserByID($unique_id);

    if ($user != false) {
        // use is found
        $response["error"] = FALSE;
        $response["uid"] = $user["unique_id"];
        $response["user"]["name"] = $user["name"];
        $response["user"]["email"] = $user["email"];
		$response["user"]["profil"] = $user["profil"];
        $response["user"]["created_at"] = $user["created_at"];
        $response["user"]["updated_at"] = $user["updated_at"];
        echo json_encode($response);
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "User is not registered. Please register and Try again";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters are missing!";
    echo json_encode($response);
}
?>

