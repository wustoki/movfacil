<?php
Class transacoes_mp {
    private $pdo; 
    private $conexao;
    public function __construct() {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }

    public function insere($user_id, $external_reference, $valor, $transacao_id = ""){
        $sql = "INSERT INTO transacoes_mp (user_id, external_reference, valor, transacao_id) VALUES (:user_id, :external_reference, :valor, :transacao_id)";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":user_id", $user_id);
        $sql->bindValue(":external_reference", $external_reference);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":transacao_id", $transacao_id);
        $sql->execute();
        if($sql->rowCount() > 0){
            return $this->conexao->lastInsertId();
        }else{
            //retorna ultimo erro
            return $sql->errorInfo();
        }
    }

    public function setCorrida_id($id, $corrida_id){
        $sql = "UPDATE transacoes_mp SET corrida_id = :corrida_id WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":corrida_id", $corrida_id);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function setQr_code($id, $qr_code){
        $sql = "UPDATE transacoes_mp SET qr_code = :qr_code WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":qr_code", $qr_code);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function setQr_code_base64($id, $qr_code_base64){
        $sql = "UPDATE transacoes_mp SET qr_code_base64 = :qr_code_base64 WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":qr_code_base64", $qr_code_base64);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function busca($external_reference){
        $sql = "SELECT * FROM transacoes_mp WHERE external_reference = :external_reference";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":external_reference", $external_reference);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        return $sql->fetch();
    }

    public function alteraStatus($transacao_id, $status){
        $sql = "UPDATE transacoes_mp SET status = :status WHERE transacao_id = :transacao_id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":status", $status);
        $sql->bindValue(":transacao_id", $transacao_id);
        $sql->execute();
    }

    public function inserePayment_id($transacao_id, $payment_id){
        $sql = "UPDATE transacoes_mp SET payment_id = :payment_id WHERE transacao_id = :transacao_id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":payment_id", $payment_id);
        $sql->bindValue(":transacao_id", $transacao_id);
        $sql->execute();
    }

    public function alteraIntentStatus($transacao_id, $intent_status){
        $sql = "UPDATE transacoes_mp SET intent_status = :intent_status WHERE transacao_id = :transacao_id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":intent_status", $intent_status);
        $sql->bindValue(":transacao_id", $transacao_id);
        $sql->execute();
    }
    public function buscaPorId($id){
        $sql = "SELECT * FROM transacoes_mp WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        return $sql->fetch();
    }

    public function getByTransacaoId($transacao_id){
        $sql = "SELECT * FROM transacoes_mp WHERE transacao_id = :transacao_id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":transacao_id", $transacao_id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        return $sql->fetch();
    }

    public function getByCorridaId($corrida_id){
        $sql = "SELECT * FROM transacoes_mp WHERE corrida_id = :corrida_id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":corrida_id", $corrida_id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        return $sql->fetch();
    }


}