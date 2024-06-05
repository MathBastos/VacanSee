<?php
include_once "conexao.php";

$id_reserva = $_GET["id_reserva"];
$query = "DELETE FROM reserva WHERE id_reserva = :id_reserva";
$resultado = $conn->prepare($query);
$resultado->bindParam(':id_reserva', $id_reserva);
$resultado->execute();

$retorno = $id_reserva;

echo json_encode($retorno);