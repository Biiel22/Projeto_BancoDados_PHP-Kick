<?php

    include_once "Conexao.php";

    class Usuario {
        public static function dadosUsuarioId($id) {
            $resultado = array();
            try {
                $conexao = Conexao::getInstance()->getConnection();
                $stmt = $conexao->prepare("SELECT * FROM usuario WHERE id=?");
                $stmt->execute([$id]);
                $resultado = $stmt->fetchAll();
            } catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
            return $resultado;
        }

        public static function dadosUsuarioEmailSenha($email, $senha) {
            $resultado = array();
            try {
                $conexao = Conexao::getInstance()->getConnection();
                $stmt = $conexao->prepare("SELECT * FROM usuario WHERE email=? AND senha=?");
                $stmt->execute([$email, $senha]);
                $resultado = $stmt->fetchAll();
            } catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
            return $resultado;
        }

        public static function dadosUsuarioEmail($email) {
            $resultado = array();
            try {
                $conexao = Conexao::getInstance()->getConnection();
                $stmt = $conexao->prepare("SELECT * FROM usuario WHERE email=?");
                $stmt->execute([$email]);
                $resultado = $stmt->fetchAll();
            } catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
            return $resultado;
        }

        public static function cadastrarUsuario($nome, $email, $senha) {
            try {
                $conexao = Conexao::getInstance()->getConnection();
                $stmt = $conexao->prepare("INSERT INTO usuario(nome, email, senha) VALUES (?, ?, ?)");
                $stmt->execute([$nome, $email, $senha]);
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

        public static function editarUsuario($nome, $email, $senha, $idUsuario) {
            try {
                $conexao = Conexao::getInstance()->getConnection();
                $stmt = $conexao->prepare("UPDATE usuario SET nome=?, email=?, senha=? WHERE id=?");
                $stmt->execute([$nome, $email, $senha, $idUsuario]);
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