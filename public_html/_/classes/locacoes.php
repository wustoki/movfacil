<?php
class locacoes
{
    private $pdo;
    private $conexao;
    public function __construct()
    {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }

    public function insere($veiculo_id, $motorista_id, $km_inicial)
    {
        $sql = $this->conexao->prepare("INSERT INTO locacoes (veiculo_id, motorista_id, km_inicial) VALUES (:veiculo_id, :motorista_id, :km_inicial)");
        $sql->bindValue(":veiculo_id", $veiculo_id);
        $sql->bindValue(":motorista_id", $motorista_id);
        $sql->bindValue(":km_inicial", $km_inicial);
        $sql->execute();
        return $this->conexao->lastInsertId();
    }

    public function getByMotoristaId($motorista_id)
    {
        $sql = "SELECT l.*, v.* FROM locacoes l 
            INNER JOIN veiculos v ON l.veiculo_id = v.id 
            WHERE l.motorista_id = :motorista_id AND l.status = 0";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":motorista_id", $motorista_id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        if ($sql->rowCount() > 0) {
            return $sql->fetchAll();
        } else {
            return false;   
        }
    }

    public function getByVeiculoId($veiculo_id) 
    {
        $sql = "SELECT l.id as locacao_id, l.veiculo_id, l.motorista_id, l.km_inicial, l.km_final, l.km_viagem, l.km_fora, l.status, l.data_inicial, l.data_final,
                m.id as motorista_id, m.nome, m.cpf, m.telefone FROM locacoes l 
                INNER JOIN motoristas m ON l.motorista_id = m.id 
                WHERE l.veiculo_id = :veiculo_id and l.status = 0";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":veiculo_id", $veiculo_id);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        if ($sql->rowCount() > 0) {
            return $sql->fetchAll();
        } else {
            return false;
        }
    
    }

    public function getByDatas($cidade_id, $data_inicial, $data_final) 
    {
        $sql = "SELECT * FROM locacoes l 
                INNER JOIN motoristas m ON l.motorista_id = m.id 
                INNER JOIN veiculos v ON l.veiculo_id = v.id 
                WHERE m.cidade_id = :cidade_id AND l.data_inicial >= :data_inicial AND l.data_final <= :data_final";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":cidade_id", $cidade_id);
        $sql->bindValue(":data_inicial", $data_inicial);
        $sql->bindValue(":data_final", $data_final);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        if ($sql->rowCount() > 0) {
            return $sql->fetchAll();
        } else { 
            return false;
        }
    
    }

    //get by datas veiculo id
    public function getByDatasVeiculoId($veiculo_id, $data_inicial, $data_final) 
    {
        $sql = "SELECT * FROM locacoes l 
                INNER JOIN motoristas m ON l.motorista_id = m.id 
                INNER JOIN veiculos v ON l.veiculo_id = v.id 
                WHERE l.veiculo_id = :veiculo_id AND l.data_inicial >= :data_inicial AND l.data_final <= :data_final";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":veiculo_id", $veiculo_id);
        $sql->bindValue(":data_inicial", $data_inicial);
        $sql->bindValue(":data_final", $data_final);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        if ($sql->rowCount() > 0) {
            return $sql->fetchAll();
        } else { 
            return false;
        }
    
    }

    public function setKmFinal($id, $km_final)
    {
        $sql = "UPDATE locacoes SET km_final = :km_final WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":km_final", $km_final);
        $sql->execute();
    }

    public function setKmViagem($id, $km_viagem)
    {
        $sql = "UPDATE locacoes SET km_viagem = :km_viagem WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":km_viagem", $km_viagem);
        $sql->execute();
    }

    public function setKmFora($id, $km_fora)
    {
        $sql = "UPDATE locacoes SET km_fora = :km_fora WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":km_fora", $km_fora);
        $sql->execute();
    }

    public function setStatus($id, $status)
    { //0 = em andamento, 1 = finalizada
        $sql = "UPDATE locacoes SET status = :status WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":status", $status);
        $sql->execute();
        return true;
    }

    public function setDataFinal($id, $data_final)
    {
        $sql = "UPDATE locacoes SET data_final = :data_final WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":data_final", $data_final);
        $sql->execute();
    
    }
}
