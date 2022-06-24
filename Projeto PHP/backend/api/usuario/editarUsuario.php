<?php
header('Content-Type: application/json', true);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET");

include "../../classes/Usuario.php";

$postJson = json_decode(json_encode(json_decode(file_get_contents('php://input')), true));

try{
    if($postJson) {
        $idUsuario = $postJson->idUsuario;
        $nome = $postJson->nome;
        $email = $postJson->email;
    } else {
        $idUsuario = $_POST["idUsuario"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
    }
} catch(Exception $e) {
    $mensagem = array("status" => "ERRO", "mensagem" => $e.getMessage());
    echo json_encode($mensagem);
    exit;
}

if((isset($nome) && !empty($nome)) &&
(isset($idUsuario) && !empty($idUsuario)) &&
(isset($email) && !empty($email))
) {
    $resultado = Usuario::editarUsuario($idUsuario, $nome, $email);

    if($resultado) {
        $mensagem = array("status" => "OK");
    } else {
        $mensagem = array("status" => "ERRO", "descricao" => "Erro na edicao de usuario");
    }
} else {
    $mensagem = array("status" => "os parâmetros não foram encontrados!");
}

echo json_encode($mensagem);

?>