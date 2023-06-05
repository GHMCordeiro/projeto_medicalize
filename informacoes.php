<?php
session_start();
$usu = $_SESSION['id_usuario'];

if (!isset($usu)) {
    header('Location: index.php');
}

$id_med = $_GET['id'];

require_once('conexao.php');

$conexao = novaConexao($banco = "projeto_pi_2023");

$med = $conexao->prepare("SELECT * FROM medicamento WHERE id_med = ?");
$med->bindValue(1, $id_med);
$med->execute();
$medRes = $med->fetch(PDO::FETCH_ASSOC);

$id_receituario = $medRes['id_receituario'];
$id_identificacao = $medRes['id_identificacao'];

$recei = $conexao->prepare("SELECT * FROM receituario WHERE id_receituario = ?");
$recei->bindValue(1, $id_receituario);
$recei->execute();
$receiRes = $recei->fetch(PDO::FETCH_ASSOC);

$ident = $conexao->prepare("SELECT * FROM identificacao_med WHERE id_identificacao = ?");
$ident->bindValue(1, $id_identificacao);
$ident->execute();
$identRes = $ident->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>

<body>
    <div class="container-page">
        <header class="container-header">
            <section class="page-bar">
                <div class="return-icon"><img src="icons/chevron-left_icon.svg" alt="Voltar"></div>
                <div class="page-tittle"><p>Encontrar</p></div>
            </section>
            <section class="slide-options">
                <div id="buy" class=""><p>Informações</p></div> 
                <div id="discard"><p>Bula Simplificada</p></div>
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
            $(".slide-content section").load("med_bula.php?id=<?php echo $id_med; ?>");

            $(".return-icon").click(function(){
                $(location).attr('href', 'pesquisar_bula.php');
            });

            $("#buy").click(function() {
                $("#buy").css('border-bottom', '4px solid #82AC9F');
                $("#discard").css('border-bottom', 'none');
                $(".slide-content section").load("med_bula.php?id=<?php echo $id_med; ?>");
            });

            $("#discard").click(function() {
                $("#discard").css('border-bottom', '4px solid #82AC9F');
                $("#buy").css('border-bottom', 'none');
                $(".slide-content section").load("info_bula.php?id=<?php echo $id_med; ?>");
            });
        });
    </script>
</body>
</html>