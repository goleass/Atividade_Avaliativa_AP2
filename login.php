<?php

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

if(!verificaLogin($email, $password)){
    header("Location: ./index.html");
}else{
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;

    // print_r($_SESSION);
    header("Location: ./home.php");
}


function verificaLogin($email, $senha){
    
    try {
        // $conn = new PDO('mysql:host=localhost;dbname=dbphp7', 'root', '');
        $conn = new PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;ConnectionPooling=0","sa","root");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $conn->query("SELECT * FROM tb_usuarios WHERE login = '$email' AND senha = '$senha'");
        
        $r = $stmt->fetchAll();

        if(count($r)==0){
            return false;
        }
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    return true;
}