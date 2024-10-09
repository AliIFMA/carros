<?php
class Carro {
    private $con;

    public function __construct() {
        try {
            $this->con = new PDO("mysql:host=localhost;dbname=agenda", "root", "");
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'ERRO: ' . $e->getMessage();
        }
    }

    public function inserir($chassi, $modelo, $marca, $cor) {
        $verificarChassi = "SELECT COUNT(*) FROM carro WHERE chassi = :chassi";
        $stmt = $this->con->prepare($verificarChassi);
        $stmt->bindParam(':chassi', $chassi);
        $stmt->execute();

        if ($stmt->fetchColumn() > 0) {
            return;
        }

        $comando = "INSERT INTO carro (chassi, modelo, marca, cor) VALUES (?, ?, ?, ?)";
        $s = $this->con->prepare($comando);
        try {
            $s->execute([$chassi, $modelo, $marca, $cor]);
            echo "<script>alert('Carro cadastrado com sucesso!');</script>";
        } catch (PDOException $e) {
            echo 'ERRO: ' . $e->getMessage();
        }
    }

    public function atualizar($chassi, $modelo, $marca, $cor) {
        if ($this->validarDados($chassi, $modelo, $marca, $cor)) {
            $comando = "UPDATE carro SET modelo = :modelo, marca = :marca, cor = :cor WHERE chassi = :chassi";
            $s = $this->con->prepare($comando);
            
            $s->bindParam(':modelo', $modelo, PDO::PARAM_STR);
            $s->bindParam(':marca', $marca, PDO::PARAM_STR);
            $s->bindParam(':cor', $cor, PDO::PARAM_STR);
            $s->bindParam(':chassi', $chassi, PDO::PARAM_STR);
            
            try {
                $s->execute();
                if ($s->rowCount() > 0) {
                    echo "<script>alert('Carro atualizado com sucesso!');</script>"; 
                } else {
                    echo "<script>alert('Nenhum carro foi atualizado. O chassi pode não existir ou não houve alterações.');</script>"; 
                }
            } catch (PDOException $e) {
                echo "<script>alert('ERRO: Falha ao atualizar carro!');</script>"; 
            }
        } else {
            echo "<script>alert('ERRO: Dados inválidos para atualização.');</script>"; 
        }
    }

    public function deletar($idCarro) {
        if ($this->verificarVendas($idCarro)) {
            echo "<script>alert('ERRO: Não é possível deletar o carro pois existem vendas registradas.');</script>"; 
            return;
        }
        
        $comando = "DELETE FROM carro WHERE idcarro = ?";
        $s = $this->con->prepare($comando);
        try {
            $s->execute([$idCarro]);
            echo "<script>alert('Carro deletado com sucesso!');</script>"; 
        } catch (PDOException $s) {
            echo "<script>alert('ERRO: Falha ao deletar Carro - O carro esta em estoque!');</script>"; 
        }
    }
    
    public function listar() {
        $comando = "SELECT * FROM carro";
        $s = $this->con->prepare($comando);
        $s->execute();
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorChassi($chassi) {
        $comando = "SELECT * FROM carro WHERE chassi = :chassi";
        $s = $this->con->prepare($comando);
        $s->bindParam(':chassi', $chassi, PDO::PARAM_STR);
        $s->execute();
        return $s->fetch(PDO::FETCH_ASSOC);
    }
    
    public function verificarVendas($idCarro) {
        $comando = "SELECT COUNT(*) FROM venda WHERE idcarro = :idCarro";
        $s = $this->con->prepare($comando);
        $s->bindParam(':idCarro', $idCarro, PDO::PARAM_INT); 
        $s->execute();
        return $s->fetchColumn() > 0;
    }

    private function validarDados($chassi, $modelo, $marca, $cor) {
        return !empty($chassi) && !empty($modelo) && !empty($marca) && !empty($cor);
    }
}
?>