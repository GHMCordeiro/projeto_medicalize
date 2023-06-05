<?php

require_once('conexao.php');

$conexao = novaConexao($banco = "projeto_pi_2023");

if (isset($_POST['submit'])) {
    if (isset($_POST['check'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $confirmaSenha = $_POST['confirmaSenha'];
        $endereco = $_POST['endereco'];


        if ($senha == $confirmaSenha) {

            $cadastro = $conexao->prepare("INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario, endereco_usuario) VALUES (?, ?, ?, ?)");
            $cadastro->bindValue(1, $nome);
            $cadastro->bindValue(2, $email);
            $cadastro->bindValue(3, $senha);
            $cadastro->bindValue(4, $endereco);
            $cadastro->execute();

            $count = $cadastro->rowCount();

            if ($count > 0) {
                echo "
                <script>
                    alert('Cadastrado com sucesso!');
                    window.location.href = 'index.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Erro ao cadastrar! Tente novamente');
                </script>
                ";
            }

        } else {
            echo "
            <script>
                alert('Senhas não conferem!');
            </script>
            ";
        }
    } else {
        echo "
        <script>
            alert('Termos não aceitos!');
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
    <title>Cadastro</title>
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
                    <p>Vamos começar</p>
                    <p>Crie uma conta para obter todos nossos recursos</p>
                </div>
                <div class="input-group-container">
                    <div class="input-group">
                        <span class="input-icon-left"><img class="user-icon" src="icons/user_icon.svg" alt=""></span>
                        <input class="input-field" type="text" name="nome" id="" placeholder="Nome completo">
                    </div>
                    <div class="input-group">
                        <span class="input-icon-left"><img class="user-icon" src="icons/email_icon.svg" alt=""></span>
                        <input class="input-field" type="text" name="email" id="" placeholder="E-mail">
                    </div>
                    <div class="input-group">
                        <span class="input-icon-left"><img class="pass-icon" src="icons/key_icon.svg" alt=""></span>
                        <input class="input-field" type="password" name="senha" id="fieldPass" placeholder="Senha">
                        <span class="input-icon-right"><img id="showPassword" class="eye-icon" src="icons/eye-off_icon.svg" alt=""></span>
                    </div>
                    <div class="input-group">
                        <span class="input-icon-left"><img class="pass-icon" src="icons/key_icon.svg" alt=""></span>
                        <input class="input-field" type="password" name="confirmaSenha" id="" placeholder="Repetir senha">
                    </div>
                </div>
                <div class="terms-link"><input type="checkbox" name="check" id="flexCheckDefault">Li e concordo com os &nbsp;<a href="">termos de uso</a></div>
                <div class="global-button">Cadastrar</div>

                <div class="modal-container cad" style="z-index:100;">
                    <div class="modal">
                        <div class="modal-header">
                            <p>Endereço</p>
                            <span id="close-modal">
                                <img src="icons/close-thick_icon.svg" alt="">
                            </span>
                        </div>
                        <div class="modal-content">
                            <div>
                                <div class="input-group-container">
                                    <div class="input-group">
                                        <input class="input-field" type="text" name="endereco" placeholder="Ex: Rua, n°, bairro, cidade e estado">
                                        <input type="submit" class="global-button" value="Finalizar" name="submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                
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
            <div class="center-position">Já possui uma conta?<a href="index.php">Entrar</a></div>
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

            $(".global-button").click(function() {
                $(".modal-container").css({"display":"flex", "align-items":"center"});
                $(".modal-container").show();
            });

            $("#close-modal").click(function() {
                $(".modal-container").hide();
            });
        });
    </script>
</body>
</html>