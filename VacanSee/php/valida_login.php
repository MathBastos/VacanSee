<?php
session_start();
if(!$_SESSION['nome']){
    echo json_encode("Erro: Sessão não existente");
}
?>