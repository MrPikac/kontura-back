<?php

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset: UTF-8");
header("Access-Control-Allow-Methods: POST");
include_once ("../config/Database.php");
include_once ("../clasess/User.php");

$db = new Database();
$connection = $db->connect();
$user = new User($connection);

if($_SERVER['REQUEST_METHOD']==="POST") {
    $param = json_decode(file_get_contents("php://input"));
    if (!empty($param->userName) and !empty($param->password)) {
        $username = $param->userName;
        $password = $param->password;
        $user_data = $user->login($username,$password);

        if (!empty($user_data)) {
            http_response_code(200);
            echo json_encode(
                $user_data
            );
        } else {
            http_response_code(404);
        }
    }
} else {
    http_response_code(403);
    echo "Access denied!";
}
