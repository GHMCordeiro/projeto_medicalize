<?php
session_start();
$usu = $_SESSION['id_usuario'];

if (!isset($usu)) {
    header('Location: index.php');
}

require_once('conexao.php');

$conexao = novaConexao($banco = "projeto_pi_2023");

$salvos = $conexao->prepare("SELECT fav.*, farm.*, tel.tel_farmacia , s.situacao FROM favoritos fav INNER JOIN farmacia farm ON fav.id_farm = farm.id_farmacia INNER JOIN telefone_farmacia tel ON tel.id_telefone = farm.id_telefone INNER JOIN situacao_farmacia s ON s.id_situacao = farm.id_situacao");
$salvos->execute();
$num = $salvos->rowCount();

if (isset($_POST['remover'])) {
    $id = $_POST['idFav'];
    $salvo = $conexao->prepare("DELETE FROM favoritos WHERE id_favorito = ?");
    $salvo->bindValue(1, $id);
    $salvo->execute();
    header('Location: salvos.php');
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
    <title>Salvos</title>
</head>
<body>
    <div class="container-page">
        <header class="container-header">
            <section class="page-bar">
                <div class="return-icon"><img src="icons/chevron-left_icon.svg" alt="Voltar"></div>
                <div class="page-tittle"><p>Favoritos</p></div>
            </section>
            <section class="slide-options">
                <div id="buy" class=""><p>Locais de Compra</p></div> 
                <div id="discard"><p>Locais de descarte</p></div>
            </section>
        </header>
        <main class="slide-content">
            <section></section>
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
            $(".slide-content section").load("compra_fav.php");

            $(".return-icon").click(function(){
                history.back(1);
            });
        });

        $("#buy").click(function() {
                $("#buy").css('border-bottom', '4px solid #82AC9F');
                $("#discard").css('border-bottom', 'none');
                $(".slide-content section").load("compra_fav.php");
        });

        $("#discard").click(function() {
            $("#discard").css('border-bottom', '4px solid #82AC9F');
            $("#buy").css('border-bottom', 'none');
            $(".slide-content section").load("descarte_fav.php");
        });
        
    </script>
    
</body>

</html>