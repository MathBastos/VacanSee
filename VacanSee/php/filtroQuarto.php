<?php
include_once "conexao.php";

$filtro = $_GET['filtro'];

$query = "SELECT * FROM quarto WHERE valor_dia LIKE '%$filtro%'";
$resultado = $conn->prepare($query);
$resultado->execute();
$contador = 0;

$row = $resultado->rowCount();

if ($row == 0){
    $retorno[$row]["msg"] = "Nenhum registro encontrado";
}

while($row = $resultado->fetch(PDO::FETCH_ASSOC)){
    $retorno[$contador]["id"] = $row["id_Quarto"];
    $retorno[$contador]["andar"] = $row["andar"];
    $retorno[$contador]["valor_dia"] = $row['valor_dia'];
    $contador++;
}

echo json_encode($retorno);