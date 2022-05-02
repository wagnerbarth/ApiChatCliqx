<?php

// headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// inclui banco de dados e objetos
include_once '../config/database.php';
include_once '../objects/chat.php';

// obtem a conexão com banco de dados
$database = new Database();
$db = $database->getConnection();

// cria o objeto chat
$chat = new Chat($db);

// define a propriedade a ser verificada
$chat->email = isset($_GET['email']) ? $_GET['email'] : die();

$chat->senha = isset($_GET['senha']) ? $_GET['senha'] : die();

// define variaveis para mensagens
//$origem = isset($_GET['origem']) ? $_GET['origem'] : die();
//$destino = isset($_GET['destino']) ? $_GET['destino'] : die(); 

// lê o registro 
$result = $chat->verificarLogin();

if ($result != null) {

    echo json_encode(array("nome" => "$result[nome]", "login" => true));

    http_response_code(200);


} else {
    // avisa que o usuário não esta cadastrado
    echo json_encode(array("login" => false));

    // define o código de resposta como 404 not found
    //http_response_code(404);
}
