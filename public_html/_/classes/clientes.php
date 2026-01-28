<?php
Class clientes {
    private $pdo; 
    private $conexao;
    public function __construct() {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }
    public function cadastra($cidade_id, $nome, $telefone, $senha, $latitude = "0", $longitude = "0", $cpf = "", $email = "") {
        $query = "INSERT INTO clientes (cidade_id, nome, telefone, senha, latitude, longitude, cpf, email) VALUES (:cidade_id, :nome, :telefone, :senha, :latitude, :longitude, :cpf, :email)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':cidade_id', $cidade_id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':latitude', $latitude);
        $stmt->bindParam(':longitude', $longitude);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt;
    }

    public function edita($id, $nome, $telefone, $saldo = "0,00", $cpf = "", $email = "") {
        $query = "UPDATE clientes SET nome = :nome, telefone = :telefone, saldo = :saldo, cpf = :cpf, email = :email WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':saldo', $saldo);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt;
    }

    public function get_cliente_id($id){
        $query = "SELECT * FROM clientes WHERE id = :id";
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

    public function verifica_se_existe($telefone){
        $query = "SELECT * FROM clientes WHERE telefone = :telefone";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0){
            return $stmt->fetch();
        }else{
            return false;
        }
    }


    public function redefinir_senha($id, $senha){
        $query = "UPDATE clientes SET senha = :senha WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();
        return $stmt;
    }

    public function get_clientes_cidade(){
        $query = "SELECT * FROM clientes WHERE cidade_id = :cidade_id ORDER BY nome ASC";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':cidade_id', $_SESSION['cidade_id']);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0){
            $dados =  $stmt->fetchAll();
            //mostra ativos primeiro
            $ativos = array();
            $inativos = array();
            foreach ($dados as $key => $value) {
                if($value['ativo'] == 1){
                    $ativos[] = $value;
                }else{
                    $inativos[] = $value;
                }
            }
            $dados = array_merge($ativos, $inativos);
            return $dados;
        }else{
            return false;
        }
        
    }

    public function ativar_desativar($id, $ativo){
        $query = "UPDATE clientes SET ativo = :ativo WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':ativo', $ativo);
        $stmt->execute();
        return $stmt;
    }

    public function login($telefone, $senha){
        $salt = "anjdsn5s141d5";
        $senha = md5($senha.$salt);
        $query = "SELECT * FROM clientes WHERE telefone = :telefone AND senha = :senha";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0){
            return $stmt->fetch();
        }else{
            return false;
        }
    }

    public function atualiza_saldo($id, $saldo){
        $query = "UPDATE clientes SET saldo = :saldo WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':saldo', $saldo);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function get_cliente_telefone($telefone){
        $query = "SELECT * FROM clientes WHERE telefone = :telefone";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(":telefone", $telefone);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt;
        }else{
            return false;
        } 
    }

    public function resetar_senha_telefone($telefone, $senha){
        $sql = "UPDATE clientes SET senha = :senha WHERE telefone = :telefone";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":telefone", $telefone);
        $sql->bindValue(":senha", $senha);
        $sql->execute();
        return true;
    }

    public function setRefCliente($id, $ref_cliente){
        $query = "UPDATE clientes SET ref_cliente = :ref_cliente WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':ref_cliente', $ref_cliente);
        $stmt->execute();
        return $stmt;
    }





}