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
$chat->origem = isset($_GET['origem']) ? $_GET['origem'] : die();

$chat->destino = isset($_GET['destino']) ? $_GET['destino'] : die();

// define variaveis para mensagens
//$origem = isset($_GET['origem']) ? $_GET['origem'] : die();
//$destino = isset($_GET['destino']) ? $_GET['destino'] : die(); 

// lê o registro 
$result = $chat->verificarMensagem();

if ($result != null) {
    // popula o array
    $arrayChat = array();

    foreach ($result as $value) {
        array_push($arrayChat, [
            "id" => "$value[id]", "origem" => "$value[origem]", "destino" => "$value[destino]", "mensagem" => "$value[mensagem]"
        ]);
    };

    http_response_code(200);

    echo json_encode($arrayChat, JSON_PRETTY_PRINT);

} else {
    // avisa que o usuário não esta cadastrado
    echo json_encode(array("message" => "mensagem não cadastrado."));

    // define o código de resposta como 404 not found
    //http_response_code(404);
}
