<?php

    header('Content-Type: application/json', true);
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET");
    date_default_timezone_set('America/Sao_Paulo');

    $postJson = json_decode(json_encode(json_decode(file_get_contents('php://input')), true));

    include_once "../../classes/Tarefa.php";

    try{
        if($postJson) {
            $idTarefa = $postJson->idTarefa;
        } else {
            $idTarefa = $_GET["idTarefa"];
        }
    } catch(Exception $e) {
        $mensagem = array("status" => "ERRO", "mensagem" => $e.getMessage());
        echo json_encode($mensagem);
        exit;
    }

    $resultado = Tarefa::dadosTarefaId($idTarefa);
    if($resultado) {
        $lugares = [];
        for ($i=0; $i<count($resultado); $i++) {
            $lugares[] = array(
                "id" => $resultado[$i]["id"],
                "idUsuario" => $resultado[$i]["idUsuario"],
                "feito" => $resultado[$i]["feito"],
                "dataCriado" => $resultado[$i]["dataCriado"],
                "tarefa" => $resultado[$i]["tarefa"],
                "dataTermina" => $resultado[$i]["dataTermina"],
            );
        }
        $mensagem = array(
            "status" => "OK",
            "mensagem" => "Dados enontrados!",
            "resultados" => $lugares
        );
    } else {
        // header("HTTP/1.1 404 Not Found");
        $mensagem = array("status" => "ERRO", "mensagem" => "Dados não encontrados");
    }

    echo json_encode($mensagem);

?>