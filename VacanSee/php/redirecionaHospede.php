<?php
include_once "conexao.php";
session_start();
$id_hospede = $_GET["id_hospede"];
$_SESSION["id_hospede"] = $id_hospede;

$retorno = "sucesso";

echo json_encode($retorno);