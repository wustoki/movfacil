<?php
Class dados_bancarios {
    private $pdo;
    private $conexao;
    public function __construct() {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }
    
    public function insere($motorista_id, $tipo_chave, $nome_banco, $beneficiario, $chave_pix) {
        $query = "INSERT INTO dados_bancarios (motorista_id, tipo_chave, nome_banco, beneficiario, chave_pix) VALUES (:motorista_id, :tipo_chave, :nome_banco, :beneficiario, :chave_pix)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':motorista_id', $motorista_id);
        $stmt->bindParam(':tipo_chave', $tipo_chave);
        $stmt->bindParam(':nome_banco', $nome_banco);
        $stmt->bindParam(':beneficiario', $beneficiario);
        $stmt->bindParam(':chave_pix', $chave_pix);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $this->conexao->lastInsertId();
        }else{
            return $stmt->errorInfo();
        }
    }

    public function edit($id, $motorista_id, $tipo_chave, $nome_banco, $beneficiario, $chave_pix) {
        $query = "UPDATE dados_bancarios SET motorista_id = :motorista_id, tipo_chave = :tipo_chave, nome_banco = :nome_banco, beneficiario = :beneficiario, chave_pix = :chave_pix WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':motorista_id', $motorista_id);
        $stmt->bindParam(':tipo_chave', $tipo_chave);
        $stmt->bindParam(':nome_banco', $nome_banco);
        $stmt->bindParam(':beneficiario', $beneficiario);
        $stmt->bindParam(':chave_pix', $chave_pix);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
    }

    public function getByMotoristaId($motorista_id) {
        $query = "SELECT * FROM dados_bancarios WHERE motorista_id = :motorista_id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':motorista_id', $motorista_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }

}