<?php
include_once "conexao.php";
//Inicia uma nova sessão
session_start();

//Obtém o nome da atual sessão e atribui à variável $s_name
$s_name = session_name();
$offset     = 3*60*60;                              // converte 3 houras para segundos
$dateFormat = "d/m/Y h:i:s";                        // formata dia/mês/ano hora:minuto:segundo
$timeNdate  = gmdate($dateFormat, time()-$offset);  // Data Hora na timezone Brasil/BSB

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 60)) {
    // último request foi há mais de 1 minuto atrás
    session_unset();     // libera (unset) todas as variáveis de sessão 
    session_destroy();   // destrói (destroy) todos os dados de sessão do atual usuário
    echo "<p>";
    echo "Sessão expirou em " .  gmdate($dateFormat, time()-$offset) .  "<br/>";
    echo "</p>";
    // A sessão acabou de expirar
    // Esse é o momento para desviar a página para a "página inicial" ou para a "página de login" do site
    // header('Location: index.php');
}
$_SESSION['LAST_ACTIVITY'] = time(); // Atualiza time stamp da última atividade realizada  
echo "<p>";
echo "Nova sessão criada para $s_name, em " . $timeNdate .  "h <br/>";
echo "</p>";
?>