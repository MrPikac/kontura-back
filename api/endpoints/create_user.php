<?php

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset: UTF-8");
header("Access-Control-Allow-Methods: POST");
include_once ("../config/Database.php");
include_once ("../clasess/User.php");

$db = new Database();
$connection = $db->connect();
$user = new User($connection);
if($_SERVER['REQUEST_METHOD']==="POST"){
    $data = json_decode(file_get_contents("php://input"));

    $user->username = $data->userName;
    $user->password = $data->password;
    $user->firstName = $data->firstName;
    $user->lastName = $data->lastName;
    $user->email = $data->email;
    $user->contact = $data->contact;
    $user->role = $data->role;

    if ($user->create_data()) {
        http_response_code(200);
        echo "User has been added!";
    } else {
        http_response_code(500);
        echo "User has NOT been added!";
    }
} else {
    http_response_code(403);
    echo "Access denied!";
}
