<?php

class Conexao {
  private static $instance = null;
  private $conn;
  private $host = 'localhost';
  private $user = 'id19161835_projetophpuser';
  private $pass = 'RcQ&=$4uSD=iodrc';
  private $dbname = 'id19161835_projetophpbd';
   
  private function __construct() {
    $opcoes = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    try {
        $linha = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
        $this->conn = new PDO($linha, $this->user, $this->pass, $opcoes);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
  }
  
  public static function getInstance() {
    if(!self::$instance){
      self::$instance = new Conexao();
    }
   
    return self::$instance;
  }
  
  public function getConnection() {
    return $this->conn;
  }
}