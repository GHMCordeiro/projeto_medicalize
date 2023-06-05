<?php
session_start();
$usu = $_SESSION['id_usuario'];

if (!isset($usu)) {
    header('Location: index.php');
}

if (isset($_POST['farm'])) {
    $conteudo = $_POST['conteudo'];
    header('Location: farmacia_popular.php?loca=' . $conteudo);
}

if (isset($_POST['descartar'])) {
    $conteudo = $_POST['conteudo'];
    header('Location: descartar.php?loca=' . $conteudo);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/medicalize.svg" type="image/x-icon">
    <title>Home</title>
</head>

<body>
    <div class="page-home-container">
        <header class="container-header">
            <div class="text-header">
                <p>Medicalize</p>
                <p>Descubra tudo sobre medicamentos, em qualquer lugar.</p>
            </div>
            <img src="img/home_icon.svg" alt="">
        </header>
        <main class="container-content">
            <section class="services-opt">
                <button class="service-button">
                    <a href="pesquisar.php">
                        <img src="icons/search-medicine_icon.svg" alt="">
                        <p>Encontrar</p>
                    </a>
                </button>
                <button class="service-button" id="btn-discard">
                    
                        <img src="icons/discard_icon.svg" alt="" srcset="">
                        <p>Descartar</p>
                    
                </button>
                <button class="service-button">
                    <a href="pesquisar_bula.php">
                        <img src="icons/bula_icon.svg" alt="">
                        <p>Bula</p>
                    </a>
                </button>
                <button class="service-button">
                    <a href="farmacia_popular.php">
                        <img src="icons/popular-pharmacy_icon.svg" alt="">
                        <p>Farmacia popular</p>
                    </a>
                </button>
            </section>
            <section class="query-area">
                <p><a href="">Dúvidas?</a></p>
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
        <div class="modal-container">
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
    </div>

    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        $("#btn-discard").click(function() {
            $(".modal-container").css({"display":"flex", "align-items":"center"});
            $(".modal-container").show();
        });

        $("#close-modal").click(function() {
            $(".modal-container").hide();
        });

        $("#inputAviso, #btnAviso, #btnAviso2").click(function() {
            alert("A TELA QUE VAI CONTER O MAPA, COM A GERAÇÃO DE ROTAS, ESTÁ EM DESENVOLVIMENTO, POIS SE TRATA DE UMA IDEIA MAIS COMPLEXA");
        });
    </script>
</body>
</html>