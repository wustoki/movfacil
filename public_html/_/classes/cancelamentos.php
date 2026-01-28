<?php
Class cancelamentos {
    private $pdo;
    private $conexao;
    public function __construct() {
        include '../bd/conexao.php';
        $this->conexao = $pdo;
    }

    /**
     * Inserts a new cancelamento record into the database.
     *
     * @param int $corrida_id The ID of the corrida.
     * @param int $origem The origin of the cancelamento (1 = motorista, 2 = cliente).
     * @return int The ID of the last inserted cancelamento.
     */
    public function inserirCancelamento($corrida_id, $origem, $motorista_id, $usuario_id, $finalizada = 'N') {
        //origem 1 = motorista, 2 = cliente
        //finalizada N = não finalizada, S = finalizada
        $query = "INSERT INTO cancelamentos (corrida_id, origem, motorista_id, usuario_id, finalizada) VALUES (:corrida_id, :origem, :motorista_id, :usuario_id, :finalizada)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':corrida_id', $corrida_id);
        $stmt->bindParam(':origem', $origem);
        $stmt->bindParam(':motorista_id', $motorista_id);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':finalizada', $finalizada);
        $stmt->execute();
        return $this->conexao->lastInsertId();
    }

    /**
     * Retrieves a cancelamento record based on corrida_id.
     *
     * @param int $corrida_id The ID of the corrida.
     * @return array|false The cancelamento record if found, false otherwise.
     */
    public function getByCorridaId($corrida_id) {
        $query = "SELECT * FROM cancelamentos WHERE corrida_id = :corrida_id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':corrida_id', $corrida_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }

    public function getTaxaCancelamentoMotorista($motorista_id) {
        $query = "SELECT * FROM cancelamentos WHERE motorista_id = :motorista_id AND origem = 1
        LIMIT 100";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':motorista_id', $motorista_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $cancelamentos = $stmt->fetchAll();
        $finalizadas = 0;
        $total = 0;
        if(!$cancelamentos){
            return 0;
        }
        foreach ($cancelamentos as $cancelamento) {
            if ($cancelamento['finalizada'] == 'S') {
                $finalizadas++;
            }
            $total++;
        }
        return $finalizadas / $total * 100;
    }


    public function getTaxaCancelamentoCliente($usuario_id) {
        $query = "SELECT * FROM cancelamentos WHERE usuario_id = :usuario_id AND origem = 2
        LIMIT 100";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $cancelamentos = $stmt->fetchAll();
        $finalizadas = 0;
        $total = 0;
        if(!$cancelamentos){
            return 0;
        }
        foreach ($cancelamentos as $cancelamento) {
            if ($cancelamento['finalizada'] == 'S') {
                $finalizadas++;
            }
            $total++;
        }
        return $finalizadas / $total * 100;
    }


}
