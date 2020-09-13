<?php

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset: UTF-8");
header("Access-Control-Allow-Methods: PUT");
include_once ("../config/Database.php");
include_once ("../clasess/Building.php");

$db = new Database();
$connection = $db->connect();
$building = new Building($connection);

if($_SERVER['REQUEST_METHOD']==="PUT"){
    $data = json_decode(file_get_contents("php://input"));

    $building->description = $data->description;
    $building->image = $data->image;
    $building->year = $data->year;
    $building->user_id = $data->user_id;
    $building->address = $data->address;
    $building->id = $data->id;

    if ($building->update_building()) {
        http_response_code(200);
        echo "Building has been updated!";
    } else {
        http_response_code(500);
        echo "Building has NOT been updated!";
    }
} else {
    http_response_code(403);
    echo "Access denied!";
}
