<?php
include_once "conexao.php";
session_start();
$id_usuario = $_SESSION["id_usuario"];

$valor_reserva = $_POST['valorReserva'];
$dia_entrada = $_POST['dataEntrada'];
$dia_saida = $_POST['dataSaida'];
$id_quarto = $_POST['id_quarto'];

// Pega o ID hospede
$sql_fk_usuario = "SELECT * FROM hospede WHERE id_usuario = :id_usuario";
    $pega_dados_usuario = $conn->prepare($sql_fk_usuario);
    $pega_dados_usuario->bindParam(':id_usuario', $id_usuario);
    $pega_dados_usuario->execute();

    $row = $pega_dados_usuario->rowCount();
    $dados_usuario = $pega_dados_usuario->fetch(PDO::FETCH_ASSOC);
    $id_hospede = $dados_usuario['id_hospede'];

// Querry insert reserva
$query_reserva =
"INSERT 
    INTO reserva(
             dia_entrada
            ,dia_saida
            ,valor_reserva
            ,id_quarto
            ,id_hospede
            ) 
    VALUES (
    :dia_entrada
    ,:dia_saida
    ,:valor_reserva
    ,:id_quarto
    ,:id_hospede
)";

$cad_reserva = $conn->prepare($query_reserva);
$cad_reserva->bindParam(':valor_reserva', $valor_reserva);
$cad_reserva->bindParam(':dia_entrada', $dia_entrada);
$cad_reserva->bindParam(':dia_saida', $dia_saida);
$cad_reserva->bindParam(':id_quarto', $id_quarto);
$cad_reserva->bindParam(':id_hospede', $id_hospede);

$cad_reserva->execute();

if($cad_reserva->rowCount() == 1){
    // Mudando a Flag do quarto  
    $query_flag =
    "UPDATE quarto 
        SET  
            flag_reservado = 'S'
        WHERE id_quarto = :id_quarto"; 

    $flag = $conn->prepare($query_flag);
    $flag->bindParam(':id_quarto', $id_quarto);
    $flag->execute();

    $retorna = "Quarto Reservado com sucesso";
}else{
    $retorna = "Nao foi possivel reservar o quarto, tente novamente";
}


echo json_encode($retorna);