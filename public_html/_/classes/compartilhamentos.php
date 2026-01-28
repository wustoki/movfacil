<?php
Class compartilhamentos {
    private $pdo; 
    private $conexao;
    public function __construct() {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }


    public function cadastra($nome, $cidade_id, $qnt_usuarios, $porcentagem){
        $query = "INSERT INTO compartilhamentos (nome, cidade_id, qnt_usuarios, porcentagem) VALUES (:nome, :cidade_id, :qnt_usuarios, :porcentagem)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cidade_id', $cidade_id);
        $stmt->bindParam(':qnt_usuarios', $qnt_usuarios);
        $stmt->bindParam(':porcentagem', $porcentagem);
        $stmt->execute();
        return $stmt;
    }

    public function edita($id, $nome, $cidade_id, $qnt_usuarios, $porcentagem){
        $query = "UPDATE compartilhamentos SET nome = :nome, cidade_id = :cidade_id, qnt_usuarios = :qnt_usuarios, porcentagem = :porcentagem WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cidade_id', $cidade_id);
        $stmt->bindParam(':qnt_usuarios', $qnt_usuarios);
        $stmt->bindParam(':porcentagem', $porcentagem);
        $stmt->execute();
        return $stmt;
    }


    public function deletar($id) {
        $query = "DELETE FROM compartilhamentos WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $query = "SELECT * FROM compartilhamentos WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }

    public function getByCidadeId($cidade_id) {
        $query = "SELECT * FROM compartilhamentos WHERE cidade_id = :cidade_id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':cidade_id', $cidade_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

}