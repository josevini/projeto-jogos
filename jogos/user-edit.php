<!doctype html>
<html>
    <head lang="pt-br">
        <meta chaset="UTF-8">
        <title>Edição de Dados do Usuário</title>
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
                if (!is_logado()) {
                    echo msg_erro("Efetue o <a href='user-login.php'>login</a> para poder editar seus dados.");
                } else {
                    if (!isset($_POST['usuario'])) {
                        require_once "user-edit-form.php";
                    } else {
                        $usuario = $_POST['usuario'] ?? null;
                        $nome = $_POST['nome'] ?? null;
                        $tipo = $_POST['tipo'] ?? null;
                        $senha1 = $_POST['senha1'] ?? null;
                        $senha2 = $_POST['senha2'] ?? null;

                        $q = "update usuarios set usuario = '$usuario', nome = '$nome'";

                        if (empty($senha1) || empty($senha2)) {
                            echo msg_aviso("Senha antiga mantida.");
                        } else {
                            if ($senha1 === $senha2) {
                                $senha = gerarHash($senha1);
                                $q .= ", senha = $senha";
                            } else {
                                echo msg_erro("Senhas não conferem. A senha anterior será mantida.");
                            }
                        }

                        $q .= " where usuario = '".$_SESSION['user']."'";

                        $update = $banco->query($q);

                        if ($update) {
                            echo msg_sucesso("Usuário alterado com sucesso!");
                            logout();
                            echo msg_aviso("Por segurança, efetue o <a href='user-login.php'>login</a> novamente.");
                        } else {
                            echo msg_erro("Não foi possível alterar os dados.");
                        }
                    }
                }
                echo voltar();
            ?>
        </div>
        <?php require_once "rodape.php"?>
    </body>
</html>