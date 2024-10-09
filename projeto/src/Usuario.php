<?php

class Usuario {
    private $username;
    private $senha;
    private $con;

    public function __construct() {
        try {
            $this->con = new PDO("mysql:host=localhost;dbname=agenda", "root", "");
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'ERRO: ' . $e->getMessage();
        }
    }

    public function registrar($username, $senha) {
        $comando = "INSERT INTO usuario (username, senha) VALUES (?, ?)";
        $s = $this->con->prepare($comando);
        try {
            $s->execute([$username, password_hash($senha, PASSWORD_BCRYPT)]);
        } catch (PDOException $e) {
            echo 'ERRO: ' . $e->getMessage();
        }
    }

    public function login($username, $senha) {
        $comando = "SELECT * FROM usuario WHERE username = ?";
        $s = $this->con->prepare($comando);
        $s->execute([$username]);
        $usuario = $s->fetch();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            echo "<script>alert('Login bem-sucedido!');</script>"; 
            return true;
        } else {
            echo "<script>alert('Usuário ou senha inválidos.');</script>";
            return false;
        }
    }
}
?>