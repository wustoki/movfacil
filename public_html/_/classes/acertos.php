<?php
Class acertos {
    private $pdo;
    public function __construct() {
        include '../bd/conexao.php';
        $this->pdo = $pdo;
    }

    public function insere($motorista_id, $semana, $status, $valor) {
        $query = "INSERT INTO acertos (motorista_id, semana, status, valor) VALUES (:motorista_id, :semana, :status, :valor)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':motorista_id', $motorista_id);
        $stmt->bindParam(':semana', $semana);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':valor', $valor);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $this->pdo->lastInsertId();
        }else{
            return $stmt->errorInfo();
        }
    }

    public function getByMotorista($motorista_id, $semana) {
        $query = "SELECT * FROM acertos WHERE motorista_id = :motorista_id AND semana = :semana";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':motorista_id', $motorista_id);
        $stmt->bindParam(':semana', $semana);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }




}