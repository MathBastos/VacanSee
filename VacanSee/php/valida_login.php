<?php
include_once "conexao.php";
session_start();
if(!$_SESSION['nome']){
    $retorno["check"] = "deu boa";
    echo json_encode($retorno);
}else{
    $retorno["check"] = "deu ruim";
    echo json_encode($retorno);
}
?>