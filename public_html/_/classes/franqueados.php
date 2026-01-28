<?php
class franqueados
{
    private $pdo;
    private $conexao;
    public function __construct()
    {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }
    public function cadastra_usuario($nome, $usuario, $senha, $cidade_id, $comissao, $telefone, $email, $limite_credito_motorista)
    {
        $sql = $this->conexao->prepare("INSERT INTO franqueados (nome, usuario, senha, cidade_id, comissao, telefone, email, limite_credito_motorista) VALUES (:nome, :usuario, :senha, :cidade_id, :comissao, :telefone, :email, :limite_credito_motorista)");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":usuario", $usuario);
        $sql->bindValue(":senha", $senha);
        $sql->bindValue(":cidade_id", $cidade_id);
        $sql->bindValue(":comissao", $comissao);
        $sql->bindValue(":telefone", $telefone);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":limite_credito_motorista", $limite_credito_motorista);
        $sql->execute();
        //retorna o id do usuário cadastrado
        return $this->conexao->lastInsertId();
    }

    public function edit_usuario($id, $nome, $usuario, $senha, $cidade_id, $comissao, $telefone, $email, $limite_credito_motorista)
    {
        $sql = "UPDATE franqueados SET nome = :nome, usuario = :usuario, senha = :senha, cidade_id = :cidade_id, comissao = :comissao, telefone = :telefone, email = :email, limite_credito_motorista = :limite_credito_motorista WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":usuario", $usuario);
        $sql->bindValue(":senha", $senha);
        $sql->bindValue(":cidade_id", $cidade_id);
        $sql->bindValue(":comissao", $comissao);
        $sql->bindValue(":telefone", $telefone);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":limite_credito_motorista", $limite_credito_motorista);
        $sql->execute();
    }


    public function get_user_id($usuario)
    {
        $sql = "SELECT id FROM franqueados WHERE usuario = :usuario";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":usuario", $usuario);
        $sql->execute();
        $dados = $sql->fetch();
        return $dados['id'];
    }

    public function get_usuarios_cidade($cidade_id)
    {
        $sql = "SELECT * FROM franqueados WHERE cidade_id = :cidade_id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":cidade_id", $cidade_id);
        $sql->execute();
        $dados = $sql->fetchAll();
        return $dados;
    }

    public function get_usuarios_loja($loja_id)
    {
        $sql = "SELECT * FROM franqueados WHERE loja_id = :loja_id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":loja_id", $loja_id);
        $sql->execute();
        $dados = $sql->fetchAll();
        return $dados;
    }



    public function delet_usuario($id)
    {
        $sql = "DELETE FROM franqueados WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function get_usuario_id($id)
    {
        $sql = "SELECT * FROM franqueados WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        $dados = $sql->fetch();
        return $dados;
    }

    public function login($usuario, $senha)
    {
        $sql = "SELECT * FROM franqueados WHERE usuario = :usuario AND senha = :senha";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":usuario", $usuario);
        $sql->bindValue(":senha", $senha);
        $sql->execute();
        $dados = $sql->fetch();
        return $dados;
    }


    public function setAcesso($id, $acesso)
    {
        $sql = "UPDATE franqueados SET acesso = :acesso WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":acesso", $acesso);
        $sql->execute();
    }
    
    public function setCpf($id, $cpf){
        $sql = "UPDATE franqueados SET cpf = :cpf WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":cpf", $cpf);
        $sql->execute();    

    }

    public function setCnpj($id, $cnpj){
        $sql = "UPDATE franqueados SET cnpj = :cnpj WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":cnpj", $cnpj);
        $sql->execute();
    }

    public function setNomeEmpresa($id, $nome_empresa){
        $sql = "UPDATE franqueados SET nome_empresa = :nome_empresa WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":nome_empresa", $nome_empresa);
        $sql->execute();
    }

    public function setDocEmpresa($id, $doc_empresa){
        $sql = "UPDATE franqueados SET doc_empresa = :doc_empresa WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":doc_empresa", $doc_empresa);
        $sql->execute();
    
    }

    public function setDocPessoal($id, $doc_pessoal){
        $sql = "UPDATE franqueados SET doc_pessoal = :doc_pessoal WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":doc_pessoal", $doc_pessoal);
        $sql->execute();
    }


    public function setCompEndereco($id, $comp_endereco){
        $sql = "UPDATE franqueados SET comp_endereco = :comp_endereco WHERE id = :id";
        $sql = $this->conexao->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":comp_endereco", $comp_endereco);
        $sql->execute();
    
    }

    
}
