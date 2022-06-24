<?php

    include_once "Conexao.php";

    class Tarefa {

        public static function dadosTarefasIdUsuario($idUsuario) {
            $resultado = array();
            try {
                $conexao = Conexao::getInstance()->getConnection();
                $stmt = $conexao->prepare("SELECT * FROM tarefa WHERE idUsuario=? ORDER BY tarefa.feito ASC, tarefa.dataTermina ASC");
                $stmt->execute([$idUsuario]);
                $resultado = $stmt->fetchAll();
            } catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
            return $resultado;
        }

        public static function dadosTarefaId($idTarefa) {
            $resultado = array();
            try {
                $conexao = Conexao::getInstance()->getConnection();
                $stmt = $conexao->prepare("SELECT * FROM tarefa WHERE id=?");
                $stmt->execute([$idTarefa]);
                $resultado = $stmt->fetchAll();
            } catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
            return $resultado;
        }

        public static function dadosFeitoTarefa($idTarefa) {
            $resultado = array();
            try {
                $conexao = Conexao::getInstance()->getConnection();
                $stmt = $conexao->prepare("SELECT tarefa.feito FROM tarefa WHERE id=?");
                $stmt->execute([$idTarefa]);
                $resultado = $stmt->fetchAll();
            } catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
            return $resultado;
        }

        public static function cadastrarTarefa($feito, $dataCriado, $tarefa, $dataTermina, $idUsuario) {
            try {
                $conexao = Conexao::getInstance()->getConnection();
                $stmt = $conexao->prepare("INSERT INTO tarefa(feito, dataCriado, tarefa, dataTermina, idUsuario) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$feito, $dataCriado, $tarefa, $dataTermina, $idUsuario]);
                $linhas_alteradas = $stmt->rowCount();
            } catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
            if($linhas_alteradas > 0) {
                return true;
            } else {
                return false;
            }
        }

        public static function editarTarefa($idTarefa, $tarefa, $dataTermina) {
            try {
                $conexao = Conexao::getInstance()->getConnection();
                $stmt = $conexao->prepare("UPDATE tarefa SET tarefa=?, dataTermina=? WHERE id=?");
                $stmt->execute([$tarefa, $dataTermina, $idTarefa]);
                $linhas_alteradas = $stmt->rowCount();
            } catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
            if($linhas_alteradas > 0) {
                return true;
            } else {
                return false;
            }
        }

        public static function alterarFeito($idTarefa, $feito) {
            try {
                $conexao = Conexao::getInstance()->getConnection();
                $stmt = $conexao->prepare("UPDATE tarefa SET feito=? WHERE id=?");
                $stmt->execute([$feito, $idTarefa]);
                $linhas_alteradas = $stmt->rowCount();
            } catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
            if($linhas_alteradas > 0) {
                return true;
            } else {
                return false;
            }
        }

        public static function deletarTarefaId($idTarefa) {
            try {
                $conexao = Conexao::getInstance()->getConnection();
                $stmt = $conexao->prepare("DELETE FROM tarefa WHERE id=?");
                $stmt->execute([$idTarefa]);
                $linhas_alteradas = $stmt->rowCount();
            } catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
            if($linhas_alteradas > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

?>