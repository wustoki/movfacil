<?php
Class divisao_locacoes {
    private $pdo;
    private $conexao;
    public function __construct() {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }

    // são 3 partes que no total da 100% de divisão
    public function insere($cidade_id, $franqueado, $motorista, $locatario) {
        $query = "INSERT INTO divisao_locacoes (cidade_id, franqueado, motorista, locatario) VALUES (:cidade_id, :franqueado, :motorista, :locatario)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':cidade_id', $cidade_id);
        $stmt->bindParam(':franqueado', $franqueado);
        $stmt->bindParam(':motorista', $motorista);
        $stmt->bindParam(':locatario', $locatario);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            //retorna ultimo erro
            return $stmt->errorInfo();
        } else {
            return $this->conexao->lastInsertId();
        }
    
    }


    public function editar($cidade_id, $franqueado, $motorista, $locatario) {
        $query = "UPDATE divisao_locacoes SET franqueado = :franqueado, motorista = :motorista, locatario = :locatario WHERE cidade_id = :cidade_id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':cidade_id', $cidade_id);
        $stmt->bindParam(':franqueado', $franqueado);
        $stmt->bindParam(':motorista', $motorista);
        $stmt->bindParam(':locatario', $locatario);
        return $stmt->execute();
    }

    public function getByCidadeId($cidade_id) {
        $query = "SELECT * FROM divisao_locacoes WHERE cidade_id = :cidade_id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':cidade_id', $cidade_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $query = "SELECT * FROM divisao_locacoes WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }



}