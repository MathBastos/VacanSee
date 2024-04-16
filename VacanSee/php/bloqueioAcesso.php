<?php
include_once "conexao.php";

$id_usuario = $_GET["id_usuario"];
echo $id_usuario;
$query = "UPDATE usuario SET flag_bloqueado = 'S' WHERE id_usuario = :id_usuario";
$resultado = $conn->prepare($query);
$resultado->bindParam(':id_usuario', $id_usuario);
$resultado->execute();

$retorno = "sucesso";

echo json_encode($retorno);