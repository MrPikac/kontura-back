<?php

header("Access-Control-Allow-Origin: *");
#header("Content-type: application/json; charset: UTF-8");
header("Access-Control-Allow-Methods: DELETE");

include_once ("../config/Database.php");
include_once ("../clasess/Building.php");

$db = new Database();
$connection = $db->connect();
$building = new Building($connection);

if($_SERVER['REQUEST_METHOD']==="DELETE"){
    $building_id = isset($_GET['id']) ? $_GET['id'] : "";

    if(!empty($building_id)) {
        $building->id = $building_id;
        if ($user->delete_user()) {
            http_response_code(200);
            echo "Building has been deleted!";
        } else {
            http_response_code(500);
            echo "Building has NOT been deleted!";
        }
    } else {
        http_response_code(404);
        echo "You must pass user id!";
    }
} else {
    http_response_code(403);
    echo "Access denied!";
}
