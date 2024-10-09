<?php
require_once '../src/Venda.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idcarro = $_POST['idcarro'];
    $cpf_cliente = $_POST['cpf_cliente'];
    $data = $_POST['data'];
    $quantidade = $_POST['quantidade'];

    $venda = new Venda();
    $venda->registrarVenda($idcarro, $cpf_cliente, $data, $quantidade);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venda</title>
    <link rel="stylesheet" href="../styles/regVenda.css">
</head>
<body>
    <div class="container">
        <h2>Registrar Venda</h2>
        <form method="post" action="">
            <label for="idcarro">ID do Carro:</label>
            <input type="text" name="idcarro" required><br>

            <label for="cpf_cliente">CPF do Cliente:</label>
            <input type="text" name="cpf_cliente" required><br>

            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" required><br>
            
            <label for="data">Data:</label>
            <input type="date" name="data" required><br>
            
            <input type="submit" value="Registrar Venda">
        </form>
    </div>
</body>
</html>
