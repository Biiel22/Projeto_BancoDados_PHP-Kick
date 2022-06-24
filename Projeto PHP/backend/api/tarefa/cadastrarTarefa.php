<?php
header('Content-Type: application/json', true);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET");
date_default_timezone_set('America/Sao_Paulo');

include "../../classes/Tarefa.php";

$postJson = json_decode(json_encode(json_decode(file_get_contents('php://input')), true));

$feito = "false";
$dataCriado = date('Y/m/d');
try{
    if($postJson) {
        $tarefa = $postJson->tarefa;
        $dataTermina = $postJson->dataTermina;
        $idUsuario = $postJson->idUsuario;
    } else {
        $tarefa = $_POST["tarefa"];
        $dataTermina = $_POST["dataTermina"];
        $idUsuario = $_POST["idUsuario"];
    }
} catch(Exception $e) {
    $mensagem = array("status" => "ERRO", "mensagem" => $e.getMessage());
    echo json_encode($mensagem);
    exit;
}

if((isset($tarefa) && !empty($tarefa)) && 
(isset($dataTermina) && !empty($dataTermina)) &&
(isset($idUsuario) && !empty($idUsuario))
) {
    $resultado = Tarefa::cadastrarTarefa($feito, $dataCriado, $tarefa, $dataTermina, $idUsuario);

    if($resultado) {
        $mensagem = array("status" => "OK");
    } else {
        $mensagem = array("status" => "ERRO", "descricao" => "Erro no cadastro de tarefa");
    }
} else {
    $mensagem = array("status" => "os parâmetros não foram encontrados!");
}

echo json_encode($mensagem);

?>