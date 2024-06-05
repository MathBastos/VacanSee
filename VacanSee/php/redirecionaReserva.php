<?php
include_once "conexao.php";
session_start();
$id_quarto = $_GET["id_quarto"];
$_SESSION["id_quarto"] = $id_quarto;

$retorno = "sucesso";

echo json_encode($retorno);