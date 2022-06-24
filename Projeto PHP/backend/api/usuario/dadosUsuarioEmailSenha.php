<?php

    header('Content-Type: application/json', true);
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET");
    date_default_timezone_set('America/Sao_Paulo');

    include_once "../../classes/Usuario.php";

    $postJson = json_decode(json_encode(json_decode(file_get_contents('php://input')), true));

    try{
        if($postJson) {
            $email = $postJson->email;
            $senha = $postJson->senha;
        } else {
            $email = $_GET["email"];
            $senha = $_GET["senha"];
        }
    } catch(Exception $e) {
        $mensagem = array("status" => MensagensGenericas::TIPO_ERRO, "mensagem" => $e.getMessage());
    }

    if((isset($email) && !empty($email)) && 
    (isset($senha) && !empty($senha))) {
            $resultado = Usuario::dadosUsuarioEmailSenha($email, $senha);
            if($resultado) {
                $usuarios = [];
                for ($i=0; $i<count($resultado); $i++) {
                    $usuarios[] = array(
                        "id" => $resultado[$i]["id"],
                        "nome" => $resultado[$i]["nome"],
                        "email" => $resultado[$i]["email"],
                        "senha" => $resultado[$i]["senha"],
                    );
                }
                $mensagem = array(
                    "status" => "OK",
                    "mensagem" => "Dados enontrados!",
                    "resultados" => $usuarios
                );
            } else {
                // header("HTTP/1.1 404 Not Found");
                $mensagem = array("status" => "ERRO", "mensagem" => "Dados não encontrados");
            }
    } else {
        $mensagem = array("status" => "ERRO", "mensangem" => "Parametro incompletos");
    }

    echo json_encode($mensagem);

?>