<?php
include_once "conexao.php";
session_start();
$id_usuario = $_SESSION["id_usuario"];

$contador = 0;
$sql_fk_usuario = "SELECT * FROM hotel WHERE id_usuario = :id_usuario";
$pega_dados_usuario = $conn->prepare($sql_fk_usuario);
$pega_dados_usuario->bindParam(':id_usuario', $id_usuario);
$pega_dados_usuario->execute();

$row = $pega_dados_usuario->rowCount();
$dados_usuario = $pega_dados_usuario->fetch(PDO::FETCH_ASSOC);
$id_hotel = $dados_usuario['id_hotel'];

$query_quarto = 
"SELECT r.id_reserva, u.nome, q.andar, q.numero,r.valor_reserva, r.dia_entrada, r.dia_saida
    FROM reserva AS r 
        INNER JOIN hospede AS l 
            ON r.id_hospede = l.id_hospede 
        INNER JOIN quarto AS q 
            ON r.id_quarto = q.id_quarto 
        INNER JOIN usuario AS u 
            ON l.id_usuario = u.id_usuario
        INNER JOIN hotel AS lc
            ON q.id_hotel = lc.id_hotel
    WHERE lc.id_hotel = :id_hotel
";

$pega_dados = $conn->prepare($query_quarto);
$pega_dados->bindParam(':id_hotel', $id_hotel);
$pega_dados->execute();

while($row_reserva = $pega_dados->fetch(PDO::FETCH_ASSOC)){
    
    $retorno[$contador]["id"] = $row_reserva["id_reserva"];
    $retorno[$contador]["nome"] = $row_reserva["nome"];
    $retorno[$contador]["dia_entrada"] = $row_reserva["dia_entrada"];
    $retorno[$contador]["dia_saida"] = $row_reserva["dia_saida"];
    $retorno[$contador]["andar"] = $row_reserva["andar"];
    $retorno[$contador]["numero"] = $row_reserva["numero"];
    $retorno[$contador]["valor_reserva"] = $row_reserva["valor_reserva"];

    $contador++;
}
echo json_encode($retorno);