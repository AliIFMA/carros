<?php
class Cliente {
    private $cpf;
    private $nome;
    private $idade;
     private $con;

    public function __construct() {
        try {
            $this->con = new PDO("mysql:host=localhost;dbname=agenda", "root", "");
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException) {
            echo "<script>alert('ERRO: Falha ao conectar ao banco de dados!');</script>"; 
        }
    }

    public function inserir($cpf, $nome, $idade) {
        if ($this->validarDados($cpf, $nome, $idade)) {
            $comando = "INSERT INTO cliente (cpf, nome, idade) VALUES (?, ?, ?)";
            $s = $this->con->prepare($comando);
            try {
                $s->execute([$cpf, $nome, $idade]);
                echo "<script>alert('Cliente cadastrado com sucesso!');</script>"; 
            } catch (PDOException $e) {
                echo "<script>alert('ERRO: Falha ao cadastrar cliente!');</script>"; 
            }
        } else {
            echo "<script>alert('ERRO: Dados inválidos!');</script>";
        }
    }

    public function atualizar($cpf, $nome, $idade) {
        if ($this->validarDados($cpf, $nome, $idade)) {
            $comando = "UPDATE cliente SET nome = :nome, idade = :idade WHERE cpf = :cpf";
            $s = $this->con->prepare($comando);
            $s->bindParam(':nome', $nome, PDO::PARAM_STR);
            $s->bindParam(':idade', $idade, PDO::PARAM_INT);
            $s->bindParam(':cpf', $cpf, PDO::PARAM_STR);

            try {
                $s->execute();
                echo "<script>alert('Cliente atualizado com sucesso!');</script>";
            } catch (PDOException $e) {
                echo "<script>alert('ERRO: Falha ao atualizar cliente!');</script>";
            }
        } else {
            echo "<script>alert('ERRO: Dados inválidos!');</script>";
        }
    }

    public function deletar($cpf) {
        if ($this->verificarVendas($cpf)) {
            echo "<script>alert('ERRO: Não é possível excluir um cliente que possui vendas.');</script>";
            return;
        }
        
        $comando = "DELETE FROM cliente WHERE cpf = ?";
        $s = $this->con->prepare($comando);
        try {
            $s->execute([$cpf]);
            echo "<script>alert('Cliente excluído com sucesso!');</script>";
        } catch (PDOException $e) {
            echo "<script>alert('ERRO: Falha ao excluir cliente!');</script>";
        }
    }

    public function listar() {
        $comando = "SELECT * FROM cliente";
        $res = $this->con->query($comando);
        $registros = $res->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }

    public function buscarPorCpf($cpf) {
        $comando = "SELECT * FROM cliente WHERE cpf = ?";
        $s = $this->con->prepare($comando);
        $s->execute([$cpf]);
        return $s->fetch(PDO::FETCH_ASSOC);
    }

    public function verificarVendas($cpf) {
        $comando = "SELECT COUNT(*) FROM venda WHERE cpfCliente = :cpf";
        $s = $this->con->prepare($comando);
        $s->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $s->execute();
        return $s->fetchColumn() > 0;
    }

    private function validarDados($cpf, $nome, $idade) {
        if (empty($cpf) || empty($nome) || !is_numeric($idade) || $idade < 0) {
            return false;
        }
        return true;
    }
}
?>