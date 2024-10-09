<?php
class Venda {
    private $idVenda;
    private $idCarro;
    private $cpfCliente;
    private $dataVenda;
    private $quantidade;
    private $con;

    public function registrarVenda($idCarro, $cpfCliente, $dataVenda, $quantidade) {
        try {
            $con = new PDO("mysql:host=localhost;dbname=agenda", "root", "");
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare("SELECT * FROM cliente WHERE cpf = :cpfCliente");
            $stmt->bindParam(':cpfCliente', $cpfCliente);
            $stmt->execute();
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$cliente) {
                echo "<script>alert('Erro: Cliente não encontrado.');</script>";

                return false;
            }
    
            $stmt = $con->prepare("INSERT INTO venda (idCarro, cpfCliente, dataVenda, quantidade) VALUES (:idCarro, :cpfCliente, :dataVenda, :quantidade)");
            $stmt->bindParam(':idCarro', $idCarro);
            $stmt->bindParam(':cpfCliente', $cpfCliente);
            $stmt->bindParam(':dataVenda', $dataVenda);
            $stmt->bindParam(':quantidade', $quantidade);
            $stmt->execute();
    
        } catch (PDOException $e) {
            echo "<script>alert('ERROR: este ID não existe!');</script>";
            return false;
        }
    }
    
}
?>