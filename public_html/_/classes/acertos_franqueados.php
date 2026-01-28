<?php
Class acertos_franqueados {
    private $pdo;
    public function __construct() {
        include '../bd/conexao.php';
        $this->pdo = $pdo;
    }

    public function insere($franqueado_id, $semana, $status, $valor) {
        $query = "INSERT INTO acertos_franqueados (franqueado_id, semana, status, valor) VALUES (:franqueado_id, :semana, :status, :valor)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':franqueado_id', $franqueado_id);
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

    public function getByFranqueado($franqueado_id, $semana) {
        $query = "SELECT * FROM acertos_franqueados WHERE franqueado_id = :franqueado_id AND semana = :semana";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':franqueado_id', $franqueado_id);
        $stmt->bindParam(':semana', $semana);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }




}