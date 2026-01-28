<?php
Class corridas_a_avaliar {
    private $pdo; 
    private $conexao;
    public function __construct() {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }

    public function inserir($user_id, $corrida_id) {
        $query = "INSERT INTO corridas_a_avaliar (user_id, corrida_id) VALUES (:user_id, :corrida_id)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':corrida_id', $corrida_id);
        $stmt->execute();
        return $stmt;
    }

    public function getByUserId($id) {
        $query = "SELECT * FROM corridas_a_avaliar WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':user_id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($corrida = $stmt->fetch()){
            return $corrida;
        }else{
            return false;
        }

    }

    public function deleteAllFromUserId($user_id) {
        $query = "DELETE FROM corridas_a_avaliar WHERE user_id = :user_id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt;
    }

}