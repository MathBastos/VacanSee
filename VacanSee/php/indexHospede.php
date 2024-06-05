<?php
include_once "conexao.php";


$query = "SELECT * FROM quarto q 
INNER JOIN hotel h ON q.id_hotel = h.id_hotel 
INNER JOIN usuario u ON h.id_usuario = u.id_usuario
WHERE flag_reservado='N'";
$resultado = $conn->prepare($query);
$resultado->execute();
$contador = 0;

$row = $resultado->rowCount();

while($row = $resultado->fetch(PDO::FETCH_ASSOC)){

    $query_quarto = "SELECT * FROM hotel WHERE id_hotel = :id_hotel";
    $pega_dados = $conn->prepare($query_quarto);
    $pega_dados->bindParam(':id_hotel', $row['id_hotel']);
    $pega_dados->execute();

    $row_quarto = $pega_dados->fetch(PDO::FETCH_ASSOC);
    
    $retorno[$contador]["id"] = $row["id_quarto"];
    $retorno[$contador]["andar"] = $row["andar"];
    $retorno[$contador]["nome"] = $row["nome"];
    $retorno[$contador]["valor_dia"] = $row["valor_dia"];

    $contador++;
}
echo json_encode($retorno);