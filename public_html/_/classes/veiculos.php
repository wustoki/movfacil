<?php
class veiculos
{
    private $conexao;
    public function __construct()
    {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }


    public function insere($user_id, $placa, $modelo, $marca, $ano, $cor, $categoria, $tipo_combustivel){
        $sql = "INSERT INTO veiculos (user_id, placa, modelo, marca, ano, cor, categoria, tipo_combustivel) VALUES (:user_id, :placa, :modelo, :marca, :ano, :cor, :categoria, :tipo_combustivel)";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":user_id", $user_id);
        $sql->bindValue(":placa", $placa);
        $sql->bindValue(":modelo", $modelo);
        $sql->bindValue(":marca", $marca);
        $sql->bindValue(":ano", $ano);
        $sql->bindValue(":cor", $cor);
        $sql->bindValue(":categoria", $categoria);
        $sql->bindValue(":tipo_combustivel", $tipo_combustivel);
        $sql->execute();
        //retorna o id do veiculo inserido
        return $this->conexao->lastInsertId();
    }

    //funcao editar
    public function editar($id, $placa, $modelo, $marca, $ano, $cor, $categoria, $tipo_combustivel){
        $sql = "UPDATE veiculos SET placa = :placa, modelo = :modelo, marca = :marca, ano = :ano, cor = :cor, categoria = :categoria, tipo_combustivel = :tipo_combustivel WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":placa", $placa);
        $sql->bindValue(":modelo", $modelo);
        $sql->bindValue(":marca", $marca);
        $sql->bindValue(":ano", $ano);
        $sql->bindValue(":cor", $cor);
        $sql->bindValue(":categoria", $categoria);
        $sql->bindValue(":tipo_combustivel", $tipo_combustivel);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }

    public function getByUserId($user_id){
        $sql = "SELECT v.*, 
            (SELECT COUNT(*) FROM locacoes l WHERE l.veiculo_id = v.id AND l.status = 0) as em_uso 
            FROM veiculos v 
            WHERE v.user_id = :user_id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }else{
            return false;
        }
    
    }

    public function getByCidadeId($cidade_id){
        $sql = "SELECT v.*, 
                (SELECT COUNT(*) FROM locacoes l WHERE l.veiculo_id = v.id AND l.status = 0) as em_uso 
                FROM veiculos v 
                INNER JOIN clientes c ON v.user_id = c.id 
                WHERE c.cidade_id = :cidade_id AND v.status = 1";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":cidade_id", $cidade_id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0){
            $veiculos = $sql->fetchAll();
            // Filtra apenas veículos disponíveis (não em uso)
            return array_values(array_filter($veiculos, function($veiculo) {
                return $veiculo['em_uso'] == 0;
            }));
        }else{
            return false;
        }
    }

    public function getById($id){
        $sql = "SELECT * FROM veiculos WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0){
            return $sql->fetch();
        }else{
            return false;
        }
    
    }


    public function getByPlaca($placa) {
        $sql = "SELECT * FROM veiculos WHERE placa = :placa";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":placa", $placa);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0){
            return $sql->fetch();
        }else{
            return false;
        }
    
    }

    public function getAllByCidadeId($cidade_id){
        $sql = "SELECT v.*, 
            c.nome as cliente_nome,
            (SELECT COUNT(*) FROM locacoes l WHERE l.veiculo_id = v.id AND l.status = 0) as em_uso,
            (SELECT m.nome FROM locacoes l 
             INNER JOIN motoristas m ON l.motorista_id = m.id 
             WHERE l.veiculo_id = v.id AND l.status = 0 LIMIT 1) as motorista_nome
            FROM veiculos v 
            INNER JOIN clientes c ON v.user_id = c.id 
            WHERE c.cidade_id = :cidade_id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":cidade_id", $cidade_id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }else{
            return false;
        }
    
    }

    public function excluir($id){
        $sql = "DELETE FROM veiculos WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    
    }

    public function setKmAtual($id, $km_atual) {
        //transforma a string em inteiro
        $km_atual = (int) $km_atual;
        $sql = "UPDATE veiculos SET km_atual = :km_atual WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":km_atual", $km_atual);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    
    }
    
    public function setVencimento($id, $vencimento)
    {
        $sql = "UPDATE veiculos SET vencimento = :vencimento WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":vencimento", $vencimento);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }

    public function setImgFrente($id, $img_frente)
    {
        $sql = "UPDATE veiculos SET img_frente = :img_frente WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":img_frente", $img_frente);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    
    }

    public function setImgTraseira($id, $img_traseira)
    {
        $sql = "UPDATE veiculos SET img_traseira = :img_traseira WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":img_traseira", $img_traseira);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    
    }

    public function setImgLatDireita($id, $img_lat_direita)
    {
        $sql = "UPDATE veiculos SET img_lat_direita = :img_lat_direita WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":img_lat_direita", $img_lat_direita);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    
    }

    public function setImgLatEsquerda($id, $img_lat_esquerda)
    {
        $sql = "UPDATE veiculos SET img_lat_esquerda = :img_lat_esquerda WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":img_lat_esquerda", $img_lat_esquerda);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    
    }

    public function setImgDocumento($id, $img_documento)
    {
        $sql = "UPDATE veiculos SET img_documento = :img_documento WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":img_documento", $img_documento);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    
    }

    public function setStatus($id, $status) {
        $sql = "UPDATE veiculos SET status = :status WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":status", $status);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }

}
