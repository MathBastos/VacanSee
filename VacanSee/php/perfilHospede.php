<?php
include_once "conexao.php";
session_start();
$id_usuario = $_SESSION["id_usuario"];

$query = "CALL BUSCA_PERFIL($id_usuario)";
$resultado = $conn->prepare($query);
$resultado ->execute();

$resultado = $resultado->fetch(PDO::FETCH_ASSOC);
$retorno["nome"] = $resultado["nome"];
$retorno["celular"] = $resultado["celular"];
$retorno["email"] = $resultado["email"];

echo json_encode($retorno);

