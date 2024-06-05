<?php
include_once "conexao.php";
session_start();


$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$senha_md5 = md5($dados['senha']);

$query_login_hospede = "SELECT * FROM usuario WHERE usuario = :usuario AND senha = :senha";
$login_hospede = $conn->prepare($query_login_hospede);
$login_hospede->bindParam(':usuario', $dados['usuario']);
$login_hospede->bindParam(':senha', $senha_md5);
$login_hospede->execute();

$row = $login_hospede->rowCount();

if($row == 1){
    $user_hospede = $login_hospede->fetch(PDO::FETCH_ASSOC);
    $_SESSION['id_usuario'] = $user_hospede['id_usuario'];
    $_SESSION['nome'] = $user_hospede['nome'];
    $flag_bloqueado = $user_hospede['flag_bloqueado'];

    if($_SESSION['nome'] == "admin"){
        $retorna = ["admin"];
    }else{
        if($flag_bloqueado == "S"){
            $retorna = ["bloqueado"];
        }else{
            $retorna = ["sucesso"];
        }
    }
}else{
    $retorna = ["erro"];
}
echo json_encode($retorna);