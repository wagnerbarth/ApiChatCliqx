<?php

// headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS, POST');
header('Access-Control-Allow-Headers: origin, x-requested-with,Content-Type, '
        . 'Content-Range, Content-Disposition, Content-Description');
//header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, 
//Access-Control-Allow-Headers, Authorization, X-Requested-With");

// obtém conexão
include_once '../config/database.php';
 
// instancia objeto usuário
include_once '../objects/chat.php';
 
$database = new Database();
$db = $database->getConnection();
 
$chat = new Chat($db);

// recebe dados via POST - Body
$data = json_decode(file_get_contents("php://input"));
// certifica que os dados estão preenchidos
if(
    !empty($data->origem) &&
    !empty($data->destino) &&
    !empty($data->mensagem) 

){
 
    // define as propriedades
    $chat->origem = $data->origem;
    $chat->destino = $data->destino;
    $chat->mensagem = $data->mensagem;

    
 
    // cria a mensagem
    if($chat->criarMensagem()){
 
        // define código de resposta - 201 created
        http_response_code(201);
 
        // mensagem para o usuário
        echo json_encode(array("message" => "Mensagem criada com sucesso.", 
            "msg"=>$data->mensagem));
    }else{ // caso não cadastre a mensagem exibe mensagem
 
        // define código de resposta - 503 service unavailable
        http_response_code(503);
 
        // mensagem não cadastrada
        echo json_encode(array("message" => "mensagem não cadastrada!"));
    }
}else{ // mensagem de dados incompletos
 
    // define codigo de resposta - 400 bad request
    http_response_code(400);
 
    // mensagem para usuário
    //echo json_encode(array("message" => "Usuário não criado. 
    //Dados incompletos."));
    echo json_encode(array("message" => "dados incompletos"));
    
}