<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="../styles/cadUsuario.css">
    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            var toggleBtn = document.getElementById("togglePassword");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleBtn.textContent = "Ocultar";
            } else {
                passwordField.type = "password";
                toggleBtn.textContent = "Mostrar";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Cadastro de Usuário</h2>
        <form method="post" action="processar_cadastro.php" class="form-container">
            <label for="username">Usuário:</label>
            <input type="text" name="username" required><br>

            <label for="password">Senha:</label>
            <div class="password-container">
                <input type="password" name="password" id="password" required>
                <button type="button" id="togglePassword" onclick="togglePasswordVisibility()">Mostrar</button>
            </div>

            <input type="submit" value="Cadastrar">
        </form>

        <p>Já tem uma conta? <a href="index.php">Faça login aqui</a></p>
    </div>
</body>
</html>
