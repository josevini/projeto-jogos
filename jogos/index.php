<!doctype html>
<html>
    <head lang="pt-br">
        <meta chaset="UTF-8">
        <title>Listagem de Jogos</title>
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
                require_once "topo.php";
                $ordem = $_GET['o'] ?? "nome";
                $chave = $_GET['c'] ?? "";
            ?>

            <h1>Escolha seu jogo</h1>

            <form action="index.php" method="get" id="busca">
                Ordenar: 
                <a href="index.php?c=<?php echo $chave;?>">Nome</a> |
                <a href="index.php?o=produtora&c=<?php echo $chave;?>">Produtora</a> |
                <a href="index.php?o=nota DESC&c=<?php echo $chave;?>">Nota alta</a> | 
                <a href="index.php?o=nota ASC&c=<?php echo $chave;?>">Nota baixa</a> |
                <a href="index.php">Mostrar todos | </a>
                Buscar: <input type="text" name="c" size="10" maxlength="40">
                <input type="submit" value="Ok">
            </form>

            <table class="listagem">
                <?php
                    $q = "SELECT j.cod, j.nome, j.capa, g.genero, p.produtora
                    FROM jogos j JOIN produtoras p ON p.cod = j.produtora
                    JOIN generos g ON g.cod = j.genero ";


                    if (!empty($chave)) {
                        $q .= "WHERE j.nome like '%$chave%' OR p.produtora like '%$chave%' OR g.genero like '%$chave%' ORDER BY $ordem";
                    } else {
                        $q .= "ORDER BY $ordem";
                    }
                    /*switch ($ordem) {
                        case 'p':
                            $q .= " ORDER BY p.produtora";
                            break;
                        case 'na':
                            $q .= " ORDER BY j.nota DESC";
                            break;
                        case 'nb':
                            $q .= " ORDER BY j.nota ASC";
                            break;
                        default:
                            $q .= " ORDER BY j.nome";
                            break;
                    }*/

                    $busca = $banco->query($q);

                    if (!$busca) {
                        echo "Falha {$banco->error}";
                    } else {
                        if ($busca->num_rows == 0) {
                            echo "Nenhum registro encontrado!";
                        } else {
                            while ($reg = $busca->fetch_object()) {
                                $capa = carregaCapa($reg->capa);
                                echo "<tr><td><img class='mini' src='$capa'>";
                                echo "<td><a href='detalhes.php?cod=$reg->cod'>$reg->nome</a><br>";
                                echo "($reg->genero) $reg->produtora";
                                if (is_admin()) {
                                    echo "<td><i class='material-icons'>add_circle</i>";
                                    echo "<i class='material-icons'>edit</i>";
                                    echo "<i class='material-icons'>delete</i>";
                                } elseif(is_editor()) {
                                    echo "<td><i class='material-icons'>edit</i>";
                                }
                            }
                        }
                    }
                ?>
                <!-- <tr><td>Foto<td>Nome<td>Adm
                <tr><td>Foto<td>Nome<td>Adm
                <tr><td>Foto<td>Nome<td>Adm
                <tr><td>Foto<td>Nome<td>Adm -->
            </table>
        </div>
        <?php require_once "rodape.php"?>
    </body>
</html>