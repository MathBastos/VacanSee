<?php
include_once "conexao.php";

$id_quarto = $_GET["id_quarto"];
$query = "DELETE FROM quarto WHERE id_quarto = :id_quarto";
$resultado = $conn->prepare($query);
$resultado->bindParam(':id_quarto', $id_quarto);
$resultado->execute();

$retorno = "sucesso";

echo json_encode($retorno);