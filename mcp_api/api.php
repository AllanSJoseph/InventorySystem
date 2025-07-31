<?php 
// API For MCP Support
// Part of Allan's simple MCP sideproject, this is done outside the scope of the miniproject on clg and other members have no side in this...

ini_set('display_errors', 1);
error_reporting(E_ALL);


$headers = getallheaders();

if (isset($headers['AUTH_KEY'])){
    $authToken = $headers['AUTH_KEY'];

    if ($authToken !== "Bearer default-token" ){
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized API Request! Access Denied!"]);
        exit;
    }
    
} else {
    http_response_code(400);
    echo json_encode(["error" => "Bad Request! Auth Header Missing! Access Denied!"]);
    exit;
}


$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$basePath = '/invmgmt/mcp_api';
$endpoint = str_replace($basePath, "", $requestUri);
$endpoint = explode("/",trim($endpoint, '/'));

// For Debugging Purposes, comment this below code on production
// echo json_encode(["request_uri" => "$requestUri","received_endpoint" => "$endpoint"]);

switch ($endpoint[0]){
    case 'users':
        require __DIR__ . '/users.php';
        break;

    case 'inventory':
        require __DIR__ . '/inventory.php';
        break;

    case 'bills':
        require __DIR__ . '/bills.php';
        break;
    
    case 'billarchive':
        if ($method === 'GET'){
           if (isset($endpoint[1]) && $endpoint[1] != ' ') {
                $_GET['invoice_no'] = $endpoint[1];
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Endpoint Not Found!"]);
                exit;
            } 
        }
        

        require __DIR__ . "/billArchive.php";
        break;
    
    default:
        http_response_code(404);
        echo json_encode(["error" => "Endpoint Not Found!"]);
        break;
}

?>