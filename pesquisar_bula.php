<?php
session_start();
$usu = $_SESSION['id_usuario'];
$num = "";

if (!isset($usu)) {
    header('Location: index.php');
} else {
    if (isset($_POST['submit'])) {
        $conteudo = "%".trim($_POST['conteudo'])."%";

        require_once('conexao.php');
        $conexao = novaConexao($banco = "projeto_pi_2023");

        $res = $conexao->prepare("SELECT * FROM medicamento WHERE nome_med LIKE :conteudo");
        $res->bindParam(':conteudo', $conteudo, PDO::PARAM_STR);
        $res->execute();
        $num = $res->rowCount();

        if($num == 0){
            $num = "n";
        }
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
                    <form action="" method="post">
                        <button type="submit" name="submit" class="button-left"><img src="icons/magnify_icon.svg" style="width: 24px;"></button>
                        <input type="text" class="input-field" name="conteudo" placeholder="Encontrar bula" required>
                        <span class="button-right"><img src="icons/camera_icon.svg" style="width: 28px;"></span>
                    </form>
                </div>
            </section>
        </header>
        <main class="container-event">
            <section>
            <?php
                if (($num > 0) && ($num != "n")) {
                    while ($dados = $res->fetch(PDO::FETCH_ASSOC)) {

            ?>
                <a class="link-style" href="informacoes.php?id=<?php echo $dados['id_med']; ?>">
                    <div class="search-result">
                        <p><?php echo $dados['nome_med']; ?></p>
                    </div>
                </a>
            <?php } ?>
                <div class="warning-text"><p>Ainda nção encontrou?<a href="">Clique aqui</a></p></div>
            <?php 
            } else if($num == "n") { 
            ?>
                <div class="init-info">
                    <img src="icons/alert-circle_icon.svg" alt="">
                    <div class="info-text">
                        <p class="tittle-info">Nenhum resultado</p>
                        <p class="text-info">Ferifique se foi digitado corretamente ou use a busca com imagem</p>
                    </div>
                </div>
                <?php } else{ ?>
                <div class="init-info">
                    <img src="icons/bula_icon.svg" alt="">
                    <div class="info-text">
                        <p class="tittle-info">Pesquisar bula</p>
                        <p class="text-info">Conheça tudo sobre o remédio como indicações, dosagem/posologia, efeitos colaterais, contraindicações, advertências, precauções e armazenamento.</p>
                    </div>
                </div>
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