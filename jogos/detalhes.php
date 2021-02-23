<!doctype html>
<html>
    <head lang="pt-br">
        <meta chaset="UTF-8">
        <title>Detalhes do Jogo</title>
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
            <?php require_once "topo.php"?>
            <h1>Detalhes do jogo</h1>
            <table class='detalhes'>
                <?php
                    $cod = $_GET['cod'] ?? 0;

                    $q = "SELECT j.nome, j.capa, g.genero, p.produtora, j.nota, j.descricao FROM jogos j JOIN produtoras p ON p.cod = j.produtora JOIN generos g ON g.cod = j.genero WHERE j.cod = $cod";

                    $busca = $banco->query($q);
                    if (!$busca) {
                        echo "Falha: {$banco->error}";
                    } else {
                        if ($busca->num_rows == 1) {
                            $reg = $busca->fetch_object();
                            $capa = carregaCapa($reg->capa);
                            echo "<tr><td rowspan='3'><img class='full' src='$capa'>";
                            echo "<td><h2>$reg->nome</h2>";
                            echo "Nota: ".number_format($reg->nota, 1)." de 10.0";
                            if (is_admin()) {
                                echo " <i class='material-icons'>add_circle</i>";
                                echo "<i class='material-icons'>edit</i>";
                                echo "<i class='material-icons'>delete</i>";
                            } elseif(is_editor()) {
                                echo " <i class='material-icons'>edit</i>";
                            }
                            echo "<tr><td>$reg->descricao";
                        } else {
                            echo "Nenhum registro encontrado!";
                        }
                    }
                ?>
            </table>
            <?php echo voltar();?>
        </div>
        <?php require_once "rodape.php"?>
    </body>
</html>