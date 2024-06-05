<?php
include_once "conexao.php";


$query = "SELECT * FROM hotel";
$resultado = $conn->prepare($query);
$resultado->execute();
$contador = 0;

$row = $resultado->rowCount();

while($row = $resultado->fetch(PDO::FETCH_ASSOC)){

    $query_usuario = "SELECT * FROM usuario WHERE id_usuario = :id_usuario";
    $pega_dados = $conn->prepare($query_usuario);
    $pega_dados->bindParam(':id_usuario', $row['id_usuario']);
    $pega_dados->execute();

    $row_usuario = $pega_dados->fetch(PDO::FETCH_ASSOC);
    
    $retorno[$contador]["id"] = $row["id_hotel"];
    $retorno[$contador]["nome"] = $row_usuario["nome"];
    $retorno[$contador]["cnpj"] = $row["cnpj"];
    $retorno[$contador]["id_usuario"] = $row['id_usuario'];
    $retorno[$contador]["flag_bloqueado"] = $row_usuario['flag_bloqueado'];

    $contador++;
}
echo json_encode($retorno);