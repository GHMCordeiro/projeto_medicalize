<?php
include_once("database.php");

require_once('conexao.php');

$conexao = novaConexao($banco = "projeto_pi_2023");

if (isset($_POST['submit'])) {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $login = $conexao->prepare("SELECT * FROM usuario WHERE email_usuario = ? AND senha_usuario = ?");
    $login->bindValue(1, $usuario);
    $login->bindValue(2, $senha);
    $login->execute();
    $dado = $login->fetch(PDO::FETCH_ASSOC);

    $count = $login->rowCount();
  
    if ($count > 0) {
        session_start();
        $_SESSION['id_usuario'] = $dado['id_conta_usuario'];
        echo "
        <script>
            window.location.href ='home.php';
        </script>
        ";
        //header('Location: home.php');
    } else {
        echo "
        <script>
            alert('Usuario e/ou senha incorreto(s)!');
        </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="page-login_register">
        <header>
            <div class="area-logo">
                <img src="img/logo-medicalize.svg" alt="Logo Medicalize">
            </div>
        </header>
        <main>
            <form action="" method="post">
                <div class="legend">
                    <p>Bem vindo</p>
                    <p>Entre para continuar usando nossos recursos</p>
                </div>
                <div class="input-group-container">
                    <div class="input-group">
                        <span class="input-icon-left"><img class="user-icon" src="icons/email_icon.svg" alt=""></span>
                        <input class="input-field" type="text" name="usuario" id="" placeholder="E-mail">
                    </div>
                    <div class="input-group">
                        <span class="input-icon-left"><img class="pass-icon" src="icons/key_icon.svg" alt=""></span>
                        <input class="input-field" type="password" name="senha" id="fieldPass" placeholder="Senha">
                        <span class="input-icon-right"><img id="showPassword" class="eye-icon" src="icons/eye-off_icon.svg" alt=""></span>
                    </div>
                </div>
                <div class="direction-link right-position"><a href="">Esqueci minha senha</a></div>
                <input type="submit" class="global-button" value="Entrar" name="submit">
            </form>
            <div class="alternative-btn-area">
                <div class="dividing-line"><hr><p>OU</p></div>
                <button class="btn-alternative">
                    <span class="button-icon"><img class="google-icon" src="icons/logo-google_icon.svg" alt=""></span>
                    <p>Entrar com google</p>
                </button>
            </div>
        </main>
        <footer class="direction-link">
            <div class="center-position">Não possui uma conta?<a href="cadastro.php">Clique aqui</a></div>
        </footer>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#showPassword').on('click', function(){
                var passwordField = $('#fieldPass');
                var passwordFieldType = passwordField.attr('type');
                var pathImg = $(showPassword).attr("src");
                if(passwordFieldType == 'password'){
                    passwordField.attr('type', 'text');
                    $(showPassword).attr("src", "icons/eye_icon.svg");
                    $(this).val('Hide');
                } else{
                    passwordField.attr('type', 'password');
                    $(this).val('Show');
                    $(showPassword).attr("src", "icons/eye-off_icon.svg");
                }
            });
        });
    </script>
</body>
</html>