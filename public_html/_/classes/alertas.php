<?php
Class alertas {
    private $pdo;
    private $conexao;
    public function __construct() {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }

    public function insereAlerta($cidade_id, $conteudo, $link = "") {
        $query = "INSERT INTO alertas (cidade_id, conteudo, link) VALUES (:cidade_id, :conteudo, :link)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':cidade_id', $cidade_id);
        $stmt->bindParam(':conteudo', $conteudo);
        $stmt->bindParam(':link', $link);
        $stmt->execute();
        return $this->conexao->lastInsertId();
    }

    public function getAlertas($cidade_id, $last_id) {
        $query = "SELECT * FROM alertas WHERE cidade_id = :cidade_id AND id > :last_id AND date > DATE_SUB(NOW(), INTERVAL 1 WEEK)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':cidade_id', $cidade_id);
        $stmt->bindParam(':last_id', $last_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}