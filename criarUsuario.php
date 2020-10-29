<?php

$nome = $_POST['nome'];
$nascimento = $_POST['nascimento'];
$sexo = $_POST['sexo'];
$email = $_POST['email'];
$password = $_POST['password'];


if (!validaInput($email, $password, $nome, $nascimento, $sexo)) {
    // header('Location: criarConta.html');
} else {
    if (verificaSeExiste($email)) {
        header('Location: criarConta.html');
        return;
    }

    criarUsuario($email, $password, $nome, $nascimento, $sexo);
    header("Location: index.html");
}

function validaInput($email, $password, $nome, $nascimento, $sexo)
{
    if (!$sexo) return false;
    if (!$nascimento) return false;
    if (!$nome) return false;
    if (!$email) return false;
    if (!$password) return false;
    if (!substr_count($email, "@") == 1) return false;

    return true;
}

function verificaSeExiste($email)
{

    try {
        // $conn = new PDO('mysql:host=localhost;dbname=dbphp7', 'root', '');
        $conn = new PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;ConnectionPooling=0","sa","root");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $conn->query("SELECT * FROM tb_usuarios WHERE login = '$email'");
        
        $r = $stmt->fetchAll();

        if(count($r)>0){
            return true;
        }
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    return false;
}

function criarUsuario($email, $password, $nome, $nascimento, $sexo)
{

    try {
        // $conn = new PDO('mysql:host=localhost;dbname=dbphp7', 'root', '');
        $conn = new PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;ConnectionPooling=0","sa","root");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $conn->query("INSERT INTO tb_usuarios(login, senha) VALUES('$email', '$password')");
        
        $stmt->execute();
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
        exit();
    }
}
