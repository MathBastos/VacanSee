<?php
include_once "conexao.php";

$filtro = $_GET['filtro'];

$query = "SELECT * FROM quarto q 
INNER JOIN hotel h ON q.id_hotel = h.id_hotel 
INNER JOIN usuario u ON h.id_usuario = u.id_usuario
WHERE flag_reservado='N'
AND u.nome LIKE '%$filtro%'";
$resultado = $conn->prepare($query);
$resultado->execute();
$contador = 0;

$row = $resultado->rowCount();

if ($row == 0){
    $retorno[$row]["msg"] = "Nenhum registro encontrado";
}

while($row = $resultado->fetch(PDO::FETCH_ASSOC)){
    $retorno[$contador]["id"] = $row["id_quarto"];
    $retorno[$contador]["andar"] = $row["andar"];
    $retorno[$contador]["nome"] = $row["nome"];
    $retorno[$contador]["valor_dia"] = $row["valor_dia"];
    $contador++;
}

echo json_encode($retorno);