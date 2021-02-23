<!doctype html>
<html>
    <head lang="pt-br">
        <meta chaset="UTF-8">
        <title>Desconectou-se</title>
        <link rel="stylesheet" href="estilos/estilo.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <?php
            require_once "includes/banco.php";
            require_once "includes/login.php";
            require_once "includes/funcoes.php";
        ?>
    </head>

    <body>
        <div id="corpo">
            <?php
                logout();
                echo msg_sucesso("Usuário desconectado!");
                echo voltar();
            ?>
        </div>
    </body>
</html>