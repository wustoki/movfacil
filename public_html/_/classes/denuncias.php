<?php
Class denuncias {
    private $pdo;
    private $conexao;
    public function __construct() {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }

    public function insere($cidade_id, $corrida_id, $motivo, $origem, $descricao, $cliente_id, $motorista_id) {
        $query = "INSERT INTO denuncias (cidade_id, corrida_id, motivo, origem, descricao, cliente_id, motorista_id) VALUES (:cidade_id, :corrida_id, :motivo, :origem, :descricao, :cliente_id, :motorista_id)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':cidade_id', $cidade_id);
        $stmt->bindParam(':corrida_id', $corrida_id);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->bindParam(':origem', $origem);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':cliente_id', $cliente_id);
        $stmt->bindParam(':motorista_id', $motorista_id);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            //retorna ultimo erro
            return $stmt->errorInfo();
        } else {
            return $this->conexao->lastInsertId();
        }
    }

    public function getByCidadeId($cidade_id) {
        $query = "SELECT * FROM denuncias WHERE cidade_id = :cidade_id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':cidade_id', $cidade_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public function detByClienteEMotorista($cliente_id, $motorista_id, $origem = 'Usuário') {
        $query = "SELECT * FROM denuncias WHERE cliente_id = :cliente_id AND motorista_id = :motorista_id AND origem = :origem";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':cliente_id', $cliente_id);
        $stmt->bindParam(':motorista_id', $motorista_id);
        $stmt->bindParam(':origem', $origem);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount() == 0){
            return false;
        } else {
            return $stmt->fetchAll();
        }
    }

    public function del_denuncia($id) {
        $query = "DELETE FROM denuncias WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function setImg($id, $img) {
        $query = "UPDATE denuncias SET img = :imagem WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':imagem', $img);
        $stmt->execute();
    }

    public function getTotalDenunciasMotorista($id) {
        $query = "SELECT COUNT(*) FROM denuncias WHERE motorista_id = :id AND origem = 'Usuário'";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    //busca total de denuncias do motoista nos ultimos 3 meses
    public function getTotalDenunciasMotorista3Meses($id) {
        $query = "SELECT COUNT(*) FROM denuncias WHERE motorista_id = :id AND origem = 'Usuário' AND date >= DATE_SUB(NOW(), INTERVAL 3 MONTH)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    //busca total de denuncias do motoista nos ultimo 1 ano
    public function getTotalDenunciasMotorista1Ano($id) {
        $query = "SELECT COUNT(*) FROM denuncias WHERE motorista_id = :id AND origem = 'Usuário' AND date >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }


}