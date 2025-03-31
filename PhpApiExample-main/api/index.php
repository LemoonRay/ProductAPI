<?php

require_once 'config/database.php';
require_once 'config/Router.php';;

try {
    $router = new Router();
    $router->handleRequest();
} catch (Exception $e) {
    error_log("Unhandled Exception: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error. Please try again later."]);
}
