<!doctype html>
<html>
    <head lang="pt-br">
        <meta chaset="UTF-8">
        <title>Cadastrar novo usuário</title>
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
                if (!is_admin()) {
                    echo msg_erro("Área restrita! Você não é administrador!");
                } else {
                    if (!isset($_POST['usuario'])) {
                        require "user-new-form.php";
                    } else {
                        $usuario = $_POST['usuario'] ?? null;
                        $nome = $_POST['nome'] ?? null;
                        $senha1 = $_POST['senha1'] ?? null;
                        $senha2 = $_POST['senha2'] ?? null;
                        $tipo = $_POST['tipo'] ?? null;
                        
                        if ($senha1 === $senha2) {
                            if (empty($usuario) || empty($nome) || empty($senha1) || empty($senha2) || empty($tipo)) {
                                echo msg_erro("Todos os dados são obrigatórios!");
                            } else {
                                $senha = gerarHash($senha1);
                                $q = "INSERT INTO usuarios (usuario, nome, senha, tipo) VALUES ('$usuario', '$nome', '$senha', '$tipo')";
                                $insercao = $banco->query($q);
                                if ($insercao) {
                                    echo msg_sucesso("Usuário(a) $nome cadastrado(a) com sucesso!");
                                } else {
                                    echo msg_erro("Não foi possível criar o usuário $nome. Talvez o login já esteja sendo usado.");
                                }
                            }
                        } else {
                            echo msg_erro("Senhas não conferem. Repita o procedimento.");
                        }
                    }
                }

                echo voltar();
            ?>
        </div>
    </body>
</html>