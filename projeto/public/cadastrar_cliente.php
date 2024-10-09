<?php
require '../src/Cliente.php';

$cliente = new Cliente();

$cpf = '';
$nome = '';
$idade = '';
$acao = 'cadastrar';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['acao'])) {
        $cpf = $_POST['cpf'] ?? '';
        $nome = $_POST['nome'] ?? '';
        $idade = $_POST['idade'] ?? '';

        if ($_POST['acao'] === 'cadastrar') {
            $cliente->inserir($cpf, $nome, $idade);
        } elseif ($_POST['acao'] === 'atualizar') {
            $cliente->atualizar($cpf, $nome, $idade);
        } elseif ($_POST['acao'] === 'deletar') {
            if (!$cliente->verificarVendas($cpf)) {
                $cliente->deletar($cpf);
            } else {
                echo "<script>alert('Erro: Este cliente não pode ser deletado porque possui vendas registradas.');</script>";

                
            }
        }
    }
}

$clientes = $cliente->listar(); 

if (isset($_POST['acao']) && $_POST['acao'] === 'editar') {
    $cpf = $_POST['cpf'] ?? '';
    $clienteData = $cliente->buscarPorCpf($cpf);
    if ($clienteData) {
        $nome = $clienteData['nome'] ?? '';
        $idade = $clienteData['idade'] ?? '';
        $acao = 'atualizar';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gerenciar Clientes</title>
    <link rel="stylesheet" href="../styles/cadCliente.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Cadastro de Cliente</h2>
            <form method="post" action="">
                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" value="<?php echo htmlspecialchars($cpf); ?>" required><br>

                <label for="nome">Nome:</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required><br>

                <label for="idade">Idade:</label>
                <input type="number" name="idade" value="<?php echo htmlspecialchars($idade); ?>" required><br>

                <input type="hidden" name="acao" value="<?php echo htmlspecialchars($acao); ?>">
                <input type="submit" value="<?php echo ($acao === 'atualizar') ? 'Atualizar Cliente' : 'Cadastrar Cliente'; ?>">
            </form>
        </div>

        <div class="table-container">
            <h2>Listar Clientes</h2>
            <table border="1">
                <tr>
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Ações</th>
                </tr>
                <?php foreach ($clientes as $c): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($c['cpf']); ?></td>
                        <td><?php echo htmlspecialchars($c['nome']); ?></td>
                        <td><?php echo htmlspecialchars($c['idade']); ?></td>
                        <td>
                            <form method='post' action=''>
                                <input type='hidden' name='cpf' value='<?php echo htmlspecialchars($c['cpf']); ?>'>
                                <input type='hidden' name='acao' value='editar'>
                                <input type='submit' value='Editar'>
                            </form>
                            <form method='post' action=''>
                                <input type='hidden' name='cpf' value='<?php echo htmlspecialchars($c['cpf']); ?>'>
                                <input type='hidden' name='acao' value='deletar'>
                                <input type='submit' value='Deletar' onclick='return confirm("Tem certeza que deseja deletar este cliente?")'>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>
