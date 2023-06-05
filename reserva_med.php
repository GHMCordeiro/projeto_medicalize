<?php

session_start();
$usu = $_SESSION['id_usuario'];

if (!isset($usu)) {
    header('Location: index.php');
}

$id = $_GET['id'];

require_once("conexao.php");

$conexao = novaConexao($banco = "projeto_pi_2023");

$med = $conexao->prepare("SELECT * FROM medicamento m INNER JOIN estoque e ON e.id_med=m.id_med WHERE m.id_med = ?");
$med->bindValue(1, $id);
$med->execute();
$dados = $med->fetch(PDO::FETCH_ASSOC);
$vl_reserva = 4.88;

/*if (isset($_POST['reservar'])) {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];	
    $total=$_POST['total'];
   
    $horario = date('H:i:s');
    $reserva = $conexao->prepare("INSERT INTO reserva_medicamento (horario_reserva, id_conta_usuario, id_med, vl_pagar, status, nome_comp_usu, cpf_usu) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $reserva->bindValue(1, $horario);
    $reserva->bindValue(2, $usu);
    $reserva->bindValue(3, $id);
    $reserva->bindValue(4, $total);
    $reserva->bindValue(5, 'Não retirado');
    $reserva->bindValue(6, $nome);
    $reserva->bindValue(7, $cpf);

    if($reserva->execute()){
        echo "
        <script>
            alert('Reservado com sucesso!');
            window.location.href = 'home.php';
        </script>";
    }
}*/
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Reserva</title>
</head>

<body>
    <div class="container-page booking-page">
        <header class="container-header">
            <section class="page-bar">
                <div class="return-icon"><img src="icons/chevron-left_icon.svg" alt="Voltar"></div>
                <div class="page-tittle"><p>Reservar</p></div>
            </section>
        </header>
        <main  class="container-content">
            <div class="form-style">
                <section class="form">
                    <div class="legend">
                        <p>Dados</p>
                        <p>Informe os dados necessário de quem irá retirar o medicamento</p>
                    </div>
                    <div class="input-group-container">
                        <div class="input-group">
                            <input class="input-field" type="text" name="nome" id="" placeholder="Nome completo">
                        </div>
                        <div class="input-group">
                            <input class="input-field" type="text" name="cpf" id="" placeholder="CPF">
                        </div>
                    </div>
                </section>
                <section class="items">
                    <p>Item</p>
                    <div class="search-result">
                        <p><?php echo $dados['nome_med']; ?></p>
                        <p><?php echo "R$ " . $dados['valor_med']; ?></p>
                        <?php
                        if ($dados['qtd_med'] > 0) {
                        ?>
                            <span style="color: green;">Em estoque</span>
                        <?php } else{ ?>
                            <span style="color: red;">Baixo estoque</span>
                        <?php } ?>
                    </div>
                </section>
                <section class="price-details">
                    <p>Detalhes do preço</p>
                    <div class="prices">
                        <div>
                            <p>Subtotal</p>
                            <span>
                            <?php
                                $dataProcessing ="R$ ".str_replace('.', ',', $dados['valor_med']);
                                echo $dataProcessing;
                            ?>
                            </span>
                        </div>
                        <div>
                            <p>Reserva</p>
                            <span>
                            <?php
                                $dataProcessing ="R$ ".str_replace('.', ',', $vl_reserva);
                                echo $dataProcessing;
                            ?>
                            </span>
                        </div>
                        <div>
                            <p>Total</p>
                            <span>
                            <?php 
                                $total = $dados['valor_med'] + $vl_reserva;
                                $dataProcessing ="R$ ".str_replace('.', ',', $total);
                                echo $dataProcessing;
                            ?>
                            </span>
                        </div>
                    </div>
                </section>
                <button class="global-button">Continuar e Finalzar</button>
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
                history.back(1);
            });
        });
    </script>
</body>
</html>