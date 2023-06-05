<?php
session_start();
$usu = $_SESSION['id_usuario'];

if (!isset($usu)) {
    header('Location: index.php');
}

require_once('conexao.php');

$conexao = novaConexao($banco = "projeto_pi_2023");

$id = $_GET['id'];

$res = $conexao->prepare("SELECT * FROM medicamento WHERE id_med = ?");
$res->bindValue(1, $id);
$res->execute();
$dados = $res->fetch(PDO::FETCH_ASSOC);

$estoque = $conexao->prepare("SELECT * FROM estoque WHERE id_med = ?");
$estoque->bindValue(1, $dados['id_med']);
$estoque->execute();
$estoqueRes = $estoque->fetch(PDO::FETCH_ASSOC);

$farm = $conexao->prepare("SELECT * FROM farmacia WHERE id_farmacia = ?");
$farm->bindValue(1, $estoqueRes['id_farmacia']);
$farm->execute();
$farmRes = $farm->fetch(PDO::FETCH_ASSOC);

$tel = $conexao->prepare("SELECT * FROM telefone_farmacia WHERE id_telefone = ?");
$tel->bindValue(1, $farmRes['id_telefone']);
$tel->execute();
$telRes = $tel->fetch(PDO::FETCH_ASSOC);

$situFarm = $conexao->prepare("SELECT * FROM situacao_farmacia WHERE id_situacao = ?");
$situFarm->bindValue(1, $farmRes['id_situacao']);
$situFarm->execute();
$situRes = $situFarm->fetch(PDO::FETCH_ASSOC);

$salvoFarm = $conexao->prepare("SELECT * FROM favoritos WHERE id_farm = ?");
$salvoFarm->bindValue(1, $farmRes['id_farmacia']);
$salvoFarm->execute();
$salvoFarmRes = $salvoFarm->fetch(PDO::FETCH_ASSOC);
$salvoCount = $salvoFarm->rowCount();

if (isset($_POST['salvar'])) {
    $salvo = $conexao->prepare("INSERT INTO favoritos(id_farm, id_conta_usu) VALUES (?, ?)");
    $salvo->bindValue(1, $farmRes['id_farmacia']);
    $salvo->bindValue(2, $usu);
    $salvo->execute();
    header('Location: info_med.php.?id=' . $id);
}

if (isset($_POST['remover'])) {
    $salvo = $conexao->prepare("DELETE FROM favoritos WHERE id_favorito = ?");
    $salvo->bindValue(1, $salvoFarmRes['id_favorito']);
    $salvo->execute();
    header('Location: info_med.php.?id=' . $id);
}

if (isset($_POST['continuar'])) {
    if (isset($_POST['termo'])) {
        header('Location: reserva_med.php?id=' . $id);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="img/medicalize.svg" type="image/x-icon">
    <title>Local</title>
</head>

<body>
    <div class="container-page">
        <header class="container-header">
            <section class="page-bar">
                <div class="return-icon"><img src="icons/chevron-left_icon.svg" alt="Voltar"></div>
                <div class="page-tittle"><p>Encontrar</p></div>
            </section>
        </header>
        <main  class="container-content">
            <section class="pharmacy-selected">
                <div class="pharmacy-image">
                    <img src="img/image_pharmacy.svg" alt="IMAGEM DO ESTABELECIMENTO">
                </div>
                <div class="pharmacy-atributes">
                    <div class="card-container">
                        <div class="card-head">
                            <p><?php echo "Farmácia " . $farmRes['nome_farmacia']; ?></p>
                        <?php if ($salvoFarmRes == 0) { ?>
                            <form action="" method="post">
                                <button name="salvar"><img src="icons/bookmark-plus_icon.svg"></button>
                            </form>
                        <?php } else { ?>
                            <form action="" method="post">
                                <button class="" name="remover"><img src="icons/bookmark-check_icon.svg"></button>
                            </form>
                        <?php } ?>
                        </div>
                        <div class="card-body">
                            <div>
                                <img src="icons/map-marker_icon.svg" alt="">
                                <img src="icons/dot_icon.svg" alt="">
                                <p><?php echo $farmRes['endereco']; ?></p>
                            </div>
                            <div>
                                <img src="icons/phone_icon.svg" alt="">
                                <img src="icons/dot_icon.svg" alt="">
                                <p><?php echo $telRes['tel_farmacia']; ?></p>
                            </div>
                            <div>
                                <img src="icons/clock-time_icon.svg" alt="">
                                <img src="icons/dot_icon.svg" alt="">
                                <p><span><?php echo $situRes['situacao']; ?></span><?php echo " - ".$farmRes['fechamento']; ?></p>
                            </div>
                        </div>
                        <div class="dividing-line"><hr></div>
                        <div class="card-footer">
                            <div class="search-result">
                                <p><?php echo $dados['nome_med']; ?></p>
                                <p>
                                <?php
                                    $dataProcessing ="R$ ".str_replace('.', ',', $dados['valor_med']);
                                    echo $dataProcessing; 
                                ?> 
                                </p>
                                <?php
                                if ($estoqueRes['qtd_med'] > 0) {
                                ?>
                                    <span style="color: green;">Em estoque</span>
                                <?php } else{ ?>
                                    <span style="color: red;">Baixo estoque</span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="area-buttons">
                <button class="global-button" type="button" id="btn-modal-rota">Traçar rota</button>
                <?php if ($estoqueRes['qtd_med'] < 5) { ?>
                <button class="btn-alternative" type="button" id="btn-modal-reserva">Reservar medicamento</button>
                <?php } ?>
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
        
        <!--Modal traçar rota -->
        <div class="modal-container" id="rota">
            <div class="modal">
                <div class="modal-header">
                    <p>Localização</p>
                    <span id="close-modal">
                        <img src="icons/close-thick_icon.svg" alt="">
                    </span>
                </div>
                <div class="modal-content">
                    <div>
                        <div class="input-group-container">
                            <div class="input-group">
                                <input class="input-field" type="text" name="usuario" id="inputAviso" placeholder="Inserir ponto de partida">
                                <button class="button-icon-right" id="btnAviso"><img src="icons/directions_icon.svg" alt=""></button>
                            </div>
                        </div>
                    </div>
                    <div class="dividing-line"><hr><p>OU</p></div>
                    <button class="global-button" id="btnAviso2"><img src="icons/crosshairs-gps_icon.svg" alt=""><span>Meu local</span></button>
                </div>
            </div>
        </div>

        <!--Modal reservar -->
        <div class="modal-container" id="reserva">
            <div class="modal">
                <div class="modal-header">
                    <p>Termos para a reserva</p>
                    <span id="close-modal">
                        <img src="icons/close-thick_icon.svg" alt="">
                    </span>
                </div>
                <div class="modal-content">
                    <div>
                        <p>Terá que pagar o valor total mais 5% adicional ao valor do medicamento antecipadamente;</p>
                        <p>Pagamento apenas via pix;</p>
                        <p>Permitido apenas a reserva de uma unidade por medicamento;</p>
                        <p>Na retirada, é indispensável a apresentação do cpf, do contrário, não será permitida a retirada do medicamento mesmo com o pagamento ja efetuado.</p>
                    </div>
                </div>
                <div class="dividing-line"><hr></div>
                <div class="modal-footer">
                    <div>
                        <form action="" method="post">
                            <div class="checkbox-style">
                                <input type="checkbox" name="termo" id="termo-check">
                                <label for="termo-check">Li e concordo com os termos</label>
                            </div>
                            <button class="global-button" type="submit" value="continuar" name="continuar">Continuar</button>
                        </form>   
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        $("#btn-modal-rota").click(function() {
            $("#rota").css({"display":"flex", "align-items":"center"});
            $("#rota").show();
        });

        $("#rota #close-modal").click(function() {
            $("#rota").hide();
        });

        $("#btn-modal-reserva").click(function() {
            $("#reserva").css({"display":"flex", "align-items":"center"});
            $("#reserva").show();
        });

        $("#reserva #close-modal").click(function() {
            $("#reserva").hide();
        });

        $(".return-icon").click(function(){
            history.back(1);
        });

        $("#inputAviso, #btnAviso, #btnAviso2").click(function() {
            alert("A TELA QUE VAI CONTER O MAPA, COM A GERAÇÃO DE ROTAS, ESTÁ EM DESENVOLVIMENTO, POIS SE TRATA DE UMA IDEIA MAIS COMPLEXA");
        });
    </script>
</body>
</html>