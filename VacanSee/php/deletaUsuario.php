<?php
include_once "conexao.php";

$id_usuario = $_GET["id_usuario"];
$query = "DELETE FROM usuario WHERE id_usuario = :id_usuario;";
$resultado = $conn->prepare($query);
$resultado->bindParam(':id_usuario', $id_usuario);
$resultado->execute();

$retorno = "sucesso";

echo json_encode($retorno);