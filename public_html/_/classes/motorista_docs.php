<?php
Class motorista_docs {
    private $pdo;
    private $conexao;
    public function __construct() {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }

    // estrutura: `cidade_id`, `nome`, `cpf`, `senha`, `telefone`, `veiculo`, `placa`, `img_cnh`, `img_documento`, `img_lateral`, `img_frente`, `img_selfie`

    public function insert($cidade_id, $nome, $cpf, $senha, $telefone, $veiculo, $placa, $img_cnh, $img_documento, $img_lateral, $img_frente, $img_selfie, $email){
        $query = "INSERT INTO motorista_docs (cidade_id, nome, cpf, senha, telefone, veiculo, placa, img_cnh, img_documento, img_lateral, img_frente, img_selfie, email) VALUES (:cidade_id, :nome, :cpf, :senha, :telefone, :veiculo, :placa, :img_cnh, :img_documento, :img_lateral, :img_frente, :img_selfie, :email)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':cidade_id', $cidade_id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':veiculo', $veiculo);
        $stmt->bindParam(':placa', $placa);
        $stmt->bindParam(':img_cnh', $img_cnh);
        $stmt->bindParam(':img_documento', $img_documento);
        $stmt->bindParam(':img_lateral', $img_lateral);
        $stmt->bindParam(':img_frente', $img_frente);
        $stmt->bindParam(':img_selfie', $img_selfie);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        //retorna ultimo id inserido
        return $this->conexao->lastInsertId();
    }

    public function get_by_cidade($cidade_id, $aprovado = 0){
        $query = "SELECT * FROM motorista_docs WHERE cidade_id = :cidade_id AND aprovado = :aprovado";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':cidade_id', $cidade_id);
        $stmt->bindParam(':aprovado', $aprovado);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        }else{
            return false;
        }
    }

    public function get_by_id($id){
        $query = "SELECT * FROM motorista_docs WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0){
            return $stmt->fetch();
        }else{
            return false;
        }
    }

    public function verifica_cpf($cpf){
        $query = "SELECT * FROM motorista_docs WHERE cpf = :cpf";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function updateIdTabela($id, $id_tabela) {
        $query = "UPDATE motorista_docs SET id_tabela = :id_tabela WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_tabela', $id_tabela);
        $stmt->execute();
        return $stmt;
    }

    public function aprovado($id, $aprovado = 1) {
        $query = "UPDATE motorista_docs SET aprovado = :aprovado WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':aprovado', $aprovado);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Sincroniza dados da tabela principal 'motoristas' para a tabela 'motorista_docs'.
     * Atualiza apenas os registros de motoristas que ainda estão pendentes de aprovação.
     * Graças ao índice em 'id_tabela', esta operação é rápida e eficiente.
     *
     * @param int $id_tabela O ID do motorista na tabela principal 'motoristas'.
     * @param string $nome O nome atualizado do motorista.
     * @param string $veiculo O veículo atualizado.
     * @param string $placa A placa atualizada.
     * @return PDOStatement O resultado da execução do statement.
     */
    public function sincronizarDados($id_tabela, $nome, $veiculo, $placa) {
        $query = "UPDATE motorista_docs SET nome = :nome, veiculo = :veiculo, placa = :placa WHERE id_tabela = :id_tabela AND aprovado = 0";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id_tabela', $id_tabela);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':veiculo', $veiculo);
        $stmt->bindParam(':placa', $placa);
        $stmt->execute();
        return $stmt;
    }

}
?>