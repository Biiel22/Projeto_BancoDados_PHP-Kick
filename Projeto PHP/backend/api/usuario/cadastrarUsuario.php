<?php
header('Content-Type: application/json', true);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET");

include "../../classes/Usuario.php";

$postJson = json_decode(json_encode(json_decode(file_get_contents('php://input')), true));

try{
    if($postJson) {
        $nome = $postJson->nome;
        $email = $postJson->email;
        $senha = $postJson->senha;
    } else {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
    }
} catch(Exception $e) {
    $mensagem = array("status" => "ERRO", "mensagem" => $e.getMessage());
    echo json_encode($mensagem);
    exit;
}

if((isset($nome) && !empty($nome)) &&
(isset($email) && !empty($email)) &&
(isset($senha) && !empty($senha))
) {
    $resultadoEmail = Usuario::dadosUsuarioEmail($email);

    if(count($resultadoEmail) > 0) {
        $mensagem = array("status" => "ERRO", "mensagem" => "Email ja em uso!");
        echo json_encode($mensagem);
        exit;
    }

    $resultado = Usuario::cadastrarUsuario($nome, $email, $senha);

    if($resultado) {
        $mensagem = array("status" => "OK");
    } else {
        $mensagem = array("status" => "ERRO", "descricao" => "Erro no cadastro de usuario");
    }
} else {
    $mensagem = array("status" => "os parâmetros não foram encontrados!");
}

echo json_encode($mensagem);

?>