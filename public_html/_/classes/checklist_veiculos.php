<?php
class checklist_veiculos
{
    private $conexao;
    public function __construct()
    {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }


    public function insere($veiculo_id) {
        $sql = "INSERT INTO checklist_veiculo (veiculo_id) VALUES (:veiculo_id)";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":veiculo_id", $veiculo_id);
        $sql->execute();
        //retorna o id do checklist inserido
        return $this->conexao->lastInsertId();
    }

    public function setPinturaOk($id, $pintura_ok){
        $sql = "UPDATE checklist_veiculo SET pintura_ok = :pintura_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":pintura_ok", $pintura_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setVidrosOk($id, $vidros_ok){
        $sql = "UPDATE checklist_veiculo SET vidros_ok = :vidros_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":vidros_ok", $vidros_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setRetrovisoresOk($id, $retrovisores_ok){
        $sql = "UPDATE checklist_veiculo SET retrovisores_ok = :retrovisores_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":retrovisores_ok", $retrovisores_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setPneusOk($id, $pneus_ok){
        $sql = "UPDATE checklist_veiculo SET pneus_ok = :pneus_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":pneus_ok", $pneus_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setEstepeOk($id, $estepe_ok){
        $sql = "UPDATE checklist_veiculo SET estepe_ok = :estepe_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":estepe_ok", $estepe_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setMacacoOk($id, $macaco_ok){
        $sql = "UPDATE checklist_veiculo SET macaco_ok = :macaco_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":macaco_ok", $macaco_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setChaveRodaOk($id, $chave_roda_ok){
        $sql = "UPDATE checklist_veiculo SET chave_roda_ok = :chave_roda_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":chave_roda_ok", $chave_roda_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setTrianguloOk($id, $triangulo_ok){
        $sql = "UPDATE checklist_veiculo SET triangulo_ok = :triangulo_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":triangulo_ok", $triangulo_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setDocumentacaoOk($id, $documentacao_ok){
        $sql = "UPDATE checklist_veiculo SET documentacao_ok = :documentacao_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":documentacao_ok", $documentacao_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setSeguroOk($id, $seguro_ok){
        $sql = "UPDATE checklist_veiculo SET seguro_ok = :seguro_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":seguro_ok", $seguro_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setLimpezaOk($id, $limpeza_ok){
        $sql = "UPDATE checklist_veiculo SET limpeza_ok = :limpeza_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":limpeza_ok", $limpeza_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setCombustivelOk($id, $combustivel_ok){
        $sql = "UPDATE checklist_veiculo SET combustivel_ok = :combustivel_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":combustivel_ok", $combustivel_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setFaroisOk($id, $farois_ok){
        $sql = "UPDATE checklist_veiculo SET farois_ok = :farois_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":farois_ok", $farois_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setSetasOk($id, $setas_ok){
        $sql = "UPDATE checklist_veiculo SET setas_ok = :setas_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":setas_ok", $setas_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setBuzinaOk($id, $buzina_ok){
        $sql = "UPDATE checklist_veiculo SET buzina_ok = :buzina_ok WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":buzina_ok", $buzina_ok);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function setDetalhes($id, $detalhes){
        $sql = "UPDATE checklist_veiculo SET detalhes = :detalhes WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":detalhes", $detalhes);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function atualizarChecklist($id, $dados) {
        $sql = "UPDATE checklist_veiculo SET 
                pintura_ok = :pintura_ok,
                vidros_ok = :vidros_ok,
                retrovisores_ok = :retrovisores_ok,
                pneus_ok = :pneus_ok,
                estepe_ok = :estepe_ok,
                macaco_ok = :macaco_ok,
                chave_roda_ok = :chave_roda_ok,
                triangulo_ok = :triangulo_ok,
                documentacao_ok = :documentacao_ok,
                seguro_ok = :seguro_ok,
                limpeza_ok = :limpeza_ok,
                combustivel_ok = :combustivel_ok,
                farois_ok = :farois_ok,
                setas_ok = :setas_ok,
                buzina_ok = :buzina_ok,
                detalhes = :detalhes
                WHERE id = :id";
                
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":pintura_ok", $dados['pintura_ok']);
        $sql->bindValue(":vidros_ok", $dados['vidros_ok']);
        $sql->bindValue(":retrovisores_ok", $dados['retrovisores_ok']);
        $sql->bindValue(":pneus_ok", $dados['pneus_ok']);
        $sql->bindValue(":estepe_ok", $dados['estepe_ok']);
        $sql->bindValue(":macaco_ok", $dados['macaco_ok']);
        $sql->bindValue(":chave_roda_ok", $dados['chave_roda_ok']);
        $sql->bindValue(":triangulo_ok", $dados['triangulo_ok']);
        $sql->bindValue(":documentacao_ok", $dados['documentacao_ok']);
        $sql->bindValue(":seguro_ok", $dados['seguro_ok']);
        $sql->bindValue(":limpeza_ok", $dados['limpeza_ok']);
        $sql->bindValue(":combustivel_ok", $dados['combustivel_ok']);
        $sql->bindValue(":farois_ok", $dados['farois_ok']);
        $sql->bindValue(":setas_ok", $dados['setas_ok']);
        $sql->bindValue(":buzina_ok", $dados['buzina_ok']);
        $sql->bindValue(":detalhes", $dados['detalhes']);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function getChecklist($id) {
        $sql = "SELECT * FROM checklist_veiculo WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getChecklistByVeiculoId($veiculo_id) {
        $sql = "SELECT * FROM checklist_veiculo WHERE veiculo_id = :veiculo_id ORDER BY data_checagem DESC";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":veiculo_id", $veiculo_id);
        $sql->execute();
        if($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }
    
    public function excluir($id) {
        $sql = "DELETE FROM checklist_veiculo WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
}