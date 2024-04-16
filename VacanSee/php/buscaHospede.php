<?php
include_once "conexao.php";
session_start();
$id_hospede = $_SESSION["id_hospede"];

if($id_hospede > 0){
    $query = 
    "SELECT 
     hospede.id_hospede
    ,nome
    ,cpf
    ,celular
    ,data_nascimento
    ,email
    ,usuario
    ,senha
    FROM usuario 
        INNER JOIN hospede 
            ON usuario.id_usuario = hospede.id_usuario 
    WHERE hospede.id_hospede = :id_hospede
    ";

    $resultado = $conn->prepare($query);
    $resultado->bindParam(':id_hospede', $id_hospede);
    $resultado->execute();

    $row = $resultado->fetch(PDO::FETCH_ASSOC);
    $retorno["id"] = $row["id_hospede"];
    $retorno["nome"] = $row["nome"];
    $retorno["cpf"] = $row["cpf"];
    $retorno["celular"] = $row["celular"];
    $retorno["data_nascimento"] = $row["data_nascimento"];
    $retorno["email"] = $row["email"];
    $retorno["usuario"] = $row["usuario"];

}else{
    $retorno["id"] = "";
    $retorno["nome"] = "";
    $retorno["cpf"] = "";
    $retorno["celular"] = "";
    $retorno["data_nascimento"] = "";
    $retorno["email"] = "";
    $retorno["usuario"] = "";
    $retorno["senha"] = "";

}
echo json_encode($retorno);