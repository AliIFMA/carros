<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../styles/login.css">
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
        <h2>Login</h2>
        <form method="post" action="menu.php" class="form-container">
            <label for="username">Usuário:</label>
            <input type="text" name="username" required><br>

            <label for="password">Senha:</label>
            <div class="password-container">
                <input type="password" name="password" id="password" required>
                <button type="button" id="togglePassword" onclick="togglePasswordVisibility()">Mostrar</button>
            </div>

            <input type="submit" value="Login">
        </form>

        <p>Não tem uma conta? <a href="cadastro_usuario.php">Cadastre-se aqui</a></p>
    </div>
</body>
</html>
