<?php
header('Content-Type: application/json', true);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET");

include "../../classes/Tarefa.php";

$postJson = json_decode(json_encode(json_decode(file_get_contents('php://input')), true));

try{
    if($postJson) {
        $idTarefa = $postJson->idTarefa;
    } else {
        $idTarefa = $_POST["idTarefa"];
    }
} catch(Exception $e) {
    $mensagem = array("status" => "ERRO", "mensagem" => $e.getMessage());
    echo json_encode($mensagem);
    exit;
}

if((isset($idTarefa) && !empty($idTarefa))
) {
    try{
        $feito = (Tarefa::dadosFeitoTarefa($idTarefa)[0]["feito"]);
        if($feito == "false") {
            $feito = "true";
        } else {
            $feito = "false";
        }
    } catch(Exception $e) {
        $mensagem = array("status" => "ERRO", "mensagem" => $e.getMessage());
        echo json_encode($mensagem);
        exit;
    }
    $resultado = Tarefa::alterarFeito($idTarefa, $feito);

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