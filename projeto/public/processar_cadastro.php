<?php
try {
    $con = new PDO("mysql:host=localhost;dbname=agenda", "root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!empty($username) && !empty($password)) {
            $stmt = $con->prepare("SELECT COUNT(*) FROM usuarios WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            
            if ($stmt->fetchColumn() > 0) {
                echo "<script>alert('ERRO: O nome de usuário já está em uso.'); window.location.href = 'cadastro_usuario.php';</script>";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $con->prepare("INSERT INTO usuarios (username, password) VALUES (:username, :password)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $hashedPassword);

                if ($stmt->execute()) {
                    echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href = 'index.php';</script>";
                } else {
                    echo "<script>alert('Erro ao cadastrar usuário.'); window.location.href = 'cadastro_usuario.php';</script>";
                }
            }
        } else {
            echo "<script>alert('Por favor, preencha todos os campos.'); window.location.href = 'cadastro_usuario.php';</script>";
        }
    }
} catch (PDOException $e) {
    echo "<script>alert('ERRO: " . $e->getMessage() . "'); window.location.href = 'cadastro_usuario.php';</script>";
}
?>
