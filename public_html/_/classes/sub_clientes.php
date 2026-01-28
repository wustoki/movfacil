<?php
class sub_clientes
{
    private $pdo;
    private $conexao;
    public function __construct()
    {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }

    public function insere($user_id, $nome, $endereco_entrega, $latitude, $longitude, $telefone)
    {
        $cmd = "INSERT INTO sub_clientes (user_id, nome, endereco_entrega, latitude, longitude, telefone) VALUES (:user_id, :nome, :endereco_entrega, :latitude, :longitude, :telefone)";
        $sql = $this->conexao->prepare($cmd);
        $sql->bindValue(":user_id", $user_id);
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":endereco_entrega", $endereco_entrega);
        $sql->bindValue(":latitude", $latitude);
        $sql->bindValue(":longitude", $longitude);
        $sql->bindValue(":telefone", $telefone);
        return $sql->execute();
    }

    public function editarSubCliente($id, $nome, $telefone, $endereco_entrega)
    {
        $cmd = "UPDATE sub_clientes SET nome = :nome, telefone = :telefone, endereco_entrega = :endereco_entrega WHERE id = :id";
        $sql = $this->conexao->prepare($cmd);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":telefone", $telefone);
        $sql->bindValue(":endereco_entrega", $endereco_entrega);
        return $sql->execute();
    }


    public function getByTelefone($telefone)
    {
        $cmd = "SELECT * FROM sub_clientes WHERE telefone = :telefone";
        $sql = $this->conexao->prepare($cmd);
        $sql->bindValue(":telefone", $telefone);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }


    public function getById($id)
    {
        $cmd = "SELECT * FROM sub_clientes WHERE id = :id";
        $sql = $this->conexao->prepare($cmd);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUserId($user_id)
    {
        $cmd = "SELECT * FROM sub_clientes WHERE user_id = :user_id";
        $sql = $this->conexao->prepare($cmd);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluir($id) {
        $cmd = "DELETE FROM sub_clientes WHERE id = :id";
        $sql = $this->conexao->prepare($cmd);
        $sql->bindValue(":id", $id);
        return $sql->execute();
    }
}
