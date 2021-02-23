<!doctype html>
<html>
    <head lang="pt-br">
        <meta chaset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="estilos/estilo.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <style>
            div#corpo {
                width: 270px;
            }

            table td {
                padding: 6px;

            }
        </style>
        <?php
            require_once "includes/banco.php";
            require_once "includes/login.php";
            require_once "includes/funcoes.php";
        ?>
    </head>

    <body>
        <div id="corpo">
            <?php
                $u = $_POST['usuario'] ?? null;
                $s = $_POST['senha'] ?? null;

                if (is_null($u) || is_null($s)) {
                    require_once "user-login-form.php";
                } else {
                    $q = "SELECT usuario, nome, senha, tipo FROM usuarios where usuario = '$u'";
                    $busca = $banco->query($q);

                    if (!$busca) {
                        echo msg_erro("Falha ao acessar o banco de dados!");
                    } else {
                        if ($reg = $busca->fetch_object()) {
                            if (testarHash($s, $reg->senha)) {
                                echo msg_sucesso("Logado com sucesso!");
                                $_SESSION['user'] = $reg->usuario;
                                $_SESSION['nome'] = $reg->nome;
                                $_SESSION['tipo'] = $reg->tipo;
                            } else {
                                echo msg_erro("Senha inválida!");
                            }
                        } else {
                            echo msg_aviso("Usuário não existe!");
                        }
                    }
                }
                echo voltar();
            ?>
        </div>
    </body>
</html>