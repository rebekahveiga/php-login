<?php

session_start();
/*DOIS MODOS POSSÍVEIS -> LOCAL, produção*/
$modo = 'local';

if($modo == 'local'){
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "login";
}

if($modo == 'producao'){
    $servidor = "";
    $usuario = "";
    $senha = "";
    $banco = "";
}

try{
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "banco conectado com sucesso";
}
catch(PDOException $erro){
    echo "falha ao se conectar com o banco!";
}

function limparPost($dados){
    $dados = trim($dados);
    $dados = stripslashes($dados);
    $dados = htmlspecialchars($dados);
    return $dados;
}



function auth($tokenSessao){
    global $pdo;
    
    //verificar se tem autorização
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE token=? LIMIT 1");
    $sql->execute(array($tokenSessao));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    //se nao encontrar o usuario
    if(!$usuario){
        return false;
    }else{
        return $usuario;
    }
}


?>

