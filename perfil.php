<?php

session_start();
$usu = $_SESSION['id_usuario'];

if (!isset($usu)) {
    header('Location: index.php');
}

require_once('conexao.php');
$conexao = novaConexao($banco = "projeto_pi_2023");
$usuario =  $conexao->prepare("SELECT * FROM usuario WHERE id_conta_usuario = ?");
$usuario->bindValue(1, $usu);
$usuario->execute();
$dados = $usuario->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/medicalize.svg" type="image/x-icon">
    <title>Localizacão</title>
</head>
<body>
    <div class="container-page">
        <header class="container-header">
            <section class="page-bar">
                <div class="return-icon"><img src="icons/chevron-left_icon.svg" alt="Voltar"></div>
                <div class="page-tittle"><p>Perfil</p></div>
            </section>
            <section class="profile-container">
                <div class="profile-data">
                    <div class="profile-picture">
                        <img src="icons/account-circle_icon.svg" alt="Foto de Perfil">
                    </div>
                    <div class="user-atributes">
                        <p><?= $dados['nome_usuario'] ?></p>
                        <div>
                            <span><img src="icons/map-marker-full_icon.svg" alt=""></span>
                            <p><?= $dados['endereco_usuario'] ?></p>
                        </div>
                    </div>
                </div>
            </section>
        </header>
        <main class="settings-container">
            <div class="settings-options">
                <div>
                    <img src="icons/account-edit_icon.svg" alt="">
                    <p>Editar dados do usuário</p>
                </div>
                <div>
                    <img src="icons/bell_icon.svg" alt="">
                    <p>Notificações</p>
                </div>
                <div>
                    <img src="icons/lifebuoy_icon.svg" alt="">
                    <p>Ajuda e suporte</p>
                </div>
                <div>
                    <img src="icons/settings_icon.svg" alt="">
                    <p>Configurações</p>
                </div>
                <div id="logout">
                    <img src="icons/logout-variant_icon.svg" alt="">
                    <p>Sair</p>
                </div>
            </div>
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
                history.back();
            });

            $("#logout").click(function(){
                window.location.replace("index.php");
            });
        });
    </script>
</body>
</html>