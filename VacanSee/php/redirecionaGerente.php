<?php
include_once "conexao.php";
session_start();
$id_hotel = $_GET["id_hotel"];
$_SESSION["id_hotel"] = $id_hotel;

$retorno = "sucesso";

echo json_encode($retorno);