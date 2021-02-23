<?php
    require_once "includes/banco.php";

    echo "<footer>";
    /*$_SERVER['REMOTE ADDR'] - Pega o IP de quem está acessando a página*/
    echo "<p>Acessado por ".$_SERVER['REMOTE_ADDR']." Em ".date('d/M/Y')."</p>";
    echo "<p>Desenvolvido por Estudonauta &copy;</p>";
    echo "</footer>";

    $banco->close();
?>