<?php
session_start();
$usu = $_SESSION['id_usuario'];
$num = "";
$teste = "";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/medicalize.svg" type="image/x-icon">
    <title>Pesquisar</title>
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
                        <input class="input-field" type="text" name="texto" id="" placeholder="Buscar medicamento" required>
                        <span class="button-right"><img src="icons/camera_icon.svg" style="width: 28px;"></span>
                    </form>
                </div>
            </section>
        </header>
        <main class="container-event">
            <section>
                <div class="init-info">
                    <img src="icons/search-medicine_icon.svg" alt="">
                    <div class="info-text">
                        <p class="tittle-info">Encontre seu medicamento</p>
                        <p class="text-info">Pesquise os medicamentos que deseja e veja a disponibilidade nas farmácias perto de você</p>
                    </div>
                </div>
            </section>
        </main>
        <footer class="nav-container">
                <nav class="nav-bar">
                    <ul>
                        <li><a href="home.php"><img src="icons/home_icon.svg" alt=""></a></li>
                        <li><a href="#"><img src="icons/magnify_icon.svg" alt=""></a></li>
                        <li><a href="salvos.php"><img src="icons/bookmark_icon.svg" alt=""></a></li>
                        <li><a href="perfil.php"><img src="icons/account-circle_icon.svg" alt=""></a></li>
                    </ul>
                </nav>
        </footer>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".return-icon").click(function(){
                $(location).attr('href', 'home.php');
            });
        });
    </script>
</body>
</html>