<?php
header('Content-Type: application/json', true);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET");

include "../../classes/Tarefa.php";

$postJson = json_decode(json_encode(json_decode(file_get_contents('php://input')), true));

try{
    if($postJson) {
        $idTarefa = $postJson->idTarefa;
        $tarefa = $postJson->tarefa;
        $dataTermina = $postJson->dataTermina;
    } else {
        $idTarefa = $_POST["idTarefa"];
        $tarefa = $_POST["tarefa"];
        $dataTermina = $_POST["dataTermina"];
    }
} catch(Exception $e) {
    $mensagem = array("status" => "ERRO", "mensagem" => $e.getMessage());
    echo json_encode($mensagem);
    exit;
}

if((isset($idTarefa) && !empty($idTarefa)) && 
(isset($tarefa) && !empty($tarefa)) &&
(isset($dataTermina) && !empty($dataTermina))
) {
    $resultado = Tarefa::editarTarefa($idTarefa, $tarefa, $dataTermina);

    if($resultado) {
        $mensagem = array("status" => "OK");
    } else {
        $mensagem = array("status" => "ERRO", "descricao" => "Erro ao editar tarefa");
    }
} else {
    $mensagem = array("status" => "os parâmetros não foram encontrados!");
}

echo json_encode($mensagem);

?>