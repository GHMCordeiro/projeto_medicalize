<?php
require_once('conexao.php');

$conexao = novaConexao($banco = "projeto_pi_2023");

if(isset($_POST['ordenacao'])){
    switch($_POST['ordenacao']){
        case 'desc':
            header('Location:ordenacao_desc.php?busca='.$_GET['busca']);
            break;   
    }
}

$busca = "%".trim($_GET['busca'])."%";
$query = "SELECT m.id_med, m.nome_med, f.nome_farmacia, m.valor_med
FROM medicamento m
JOIN estoque e ON m.id_med = e.id_med
JOIN farmacia f ON e.id_farmacia = f.id_farmacia WHERE m.nome_med LIKE :busca";
$consulta = $conexao->prepare($query);
$consulta->bindParam(':busca', $busca, PDO::PARAM_STR);
try{
    $consulta->execute();
}catch(PDOException $e){
    echo "<b>Erro: </b>".$e->getCode()."</br>";
    echo "<b>Mensagem: </b>".$e->getMessage();
}
$dados = [];
if ($consulta->rowCount() > 0) {
    $dados = $consulta->fetchAll(PDO::FETCH_ASSOC);
}
function merge_sort($array) {
    $length = count($array);
    if ($length <= 1) {
        return $array;
    }

    $mid = (int)($length / 2);
    $left = array_slice($array, 0, $mid);
    $right = array_slice($array, $mid);

    $left = merge_sort($left);
    $right = merge_sort($right);

    return merge($left, $right);
}

function merge($left, $right) {
    $result = [];

    while (count($left) > 0 && count($right) > 0) {
        if ($left[0]['valor_med'] <= $right[0]['valor_med']) {
            $result[] = array_shift($left);
        } else {
            $result[] = array_shift($right);
        }
    }

    while (count($left) > 0) {
        $result[] = array_shift($left);
    }

    while (count($right) > 0) {
        $result[] = array_shift($right);
    }

    return $result;
}
$dadosOrdenados = merge_sort($dados);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encontrar Medicamento</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container-page">
        <header class="container-header">
            <section class="page-bar">
                <div class="return-icon"><img src="icons/chevron-left_icon.svg" alt="Voltar"></div>
                <div class="page-tittle"><p>Encontrar</p></div>
            </section>
            <section class="container-input">
                <div class="input-group">
                    <form action="listar_pesquisa.php" method="get">
                        <button class="button-left"><img src="icons/magnify_icon.svg" style="width: 24px;"></button>
                        <input class="input-field" type="text" name="texto" id="input-focus" required>
                        <span class="button-right" id="open-sort-modal"><img src="icons/sort_icon.svg" style="width: 28px;"></span>
                        <span class="button-right focus-button" id="focus-button"><img src="icons/camera_icon.svg" style="width: 28px;"></span>
                    </form>
                </div>
            </section>
        </header>
        <div class="modal-sort">
            <div class="container-options">
                <form action="" method="post">
                    <div class="option">
                        <input type="hidden" name="ordenacao" value="asc">
                        <button type="submit" class="button-option btn-border-top">Menor preço - Maior preço</button>
                    </div>
                </form>
                <form action="" method="post">
                    <div class="option">
                        <input type="hidden" name="ordenacao"  value="desc">
                        <button class="button-option btn-border-bottom">Maior preço - Menor preço</button>
                    </div>
                </form>
            </div>
        </div>
        <main class="container-event">
            <section>
                <?php 
                foreach ($dadosOrdenados as $row) {
                ?>
                <a class="link-style" href="info_med.php?id=<?php echo $row['id_med']; ?>">
                    <div class="search-result">
                        <p><?php echo $row['nome_med']; ?></p>
                        <p><?php echo $row['nome_farmacia']; ?></p>
                        <p>
                        <?php
                            $dataProcessing ="R$ ".str_replace('.', ',', $row['valor_med']);
                            echo $dataProcessing; 
                        ?>
                        </p>
                        <span>Localizar</span>
                    </div>
                </a>
    <?php }?>
            </section>
        </main>
        <footer class="nav-container">
                <nav class="nav-bar">
                    <ul>
                        <li><a href="home.php"><img src="icons/home_icon.svg" alt=""></a></li>
                        <li><a href="pesquisar.php"><img src="icons/magnify_icon.svg" alt=""></a></li>
                        <li><a href="salvos.php"><img src="icons/bookmark_icon.svg" alt=""></a></li>
                        <li><a href="perfil.php"><img src="icons/account-circle_icon.svg" alt=""></a></li>
                    </ul>
                </nav>
        </footer>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#open-sort-modal").click(function() {
                $(".modal-sort").slideToggle();
            });

            $("#input-focus").focus(function(){
                $("#open-sort-modal").hide();
                $(".modal-sort").slideUp();
                $("#focus-button").removeClass("focus-button");
            });

            $("#input-focus").focusout(function(){
                $("#open-sort-modal").show();
                $("#focus-button").addClass("focus-button");
            });

            $(".return-icon").click(function(){
                $(location).attr('href', 'pesquisar.php');
            });
        });
    </script>
</body>
</html>