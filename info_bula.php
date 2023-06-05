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

$id_orientacao = $medRes['id_orientacao_uso'];

$orient = $conexao->prepare("SELECT * FROM orientacoes_de_uso WHERE id_orient_uso = ?");
$orient->bindValue(1, $id_orientacao);
$orient->execute();
$orientRes = $orient->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/medicalize.svg" type="image/x-icon">
    <title>Document</title>
</head>

<body>
    <div class="topic-bula" id="topic01">
        <div class="title-topic">
            <p>Pra que serve esse medicamento?</p>
            <img src="icons/chevron-down_icon.svg" alt="">
        </div>
        <div class="content-topic" id="content01">
            <p><?php echo $orientRes['serve']; ?></p>
        </div>
    </div>
    <div class="topic-bula" id="topic02">
        <div class="title-topic">
            <p>Como ele funciona?</p>
            <img src="icons/chevron-down_icon.svg" alt="">
        </div>
        <div class="content-topic" id="content02">
            <p><?php echo $orientRes['como_funciona']; ?></p>
        </div>
    </div>
    <div class="topic-bula" id="topic03">
        <div class="title-topic">
            <p>Quando não devo usar?</p>
            <img src="icons/chevron-down_icon.svg" alt="">
        </div>
        <div class="content-topic" id="content03">
            <p><?php echo $orientRes['nao_usar']; ?></p>
        </div>
    </div>
    <div class="topic-bula" id="topic04">
        <div class="title-topic">
            <p>O que devo saber antes de usar?</p>
            <img src="icons/chevron-down_icon.svg" alt="">
        </div>
        <div class="content-topic" id="content04">
            <p><?php echo $orientRes['saber_antes']; ?></p>
        </div>
    </div>
    <div class="topic-bula" id="topic05">
        <div class="title-topic">
            <p>Como devo armazenar?</p>
            <img src="icons/chevron-down_icon.svg" alt="">
        </div>
        <div class="content-topic" id="content05">
            <p><?php echo $orientRes['armazenar']; ?></p>
        </div>
    </div>
    <div class="topic-bula" id="topic06">
        <div class="title-topic">
            <p>Como devo usar?</p>
            <img src="icons/chevron-down_icon.svg" alt="">
        </div>
        <div class="content-topic" id="content06">
            <p><?php echo $orientRes['como_usar']; ?></p>
        </div>
    </div>
    <div class="topic-bula" id="topic07">
        <div class="title-topic">
            <p>Quais as possiveis reações adversas?</p>
            <img src="icons/chevron-down_icon.svg" alt="">
        </div>
        <div class="content-topic" id="content07">
            <p><?php echo $orientRes['reacoes']; ?></p>
        </div>
    </div> 

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        $(function(){
            $('.topic-bula').click(function(){
                var id = "#"+$(this).attr('id');
                var pathImg = $(id + " img").attr("src");
                var content = "#"+$(id+">.content-topic").attr('id');
                if(pathImg === "icons/chevron-down_icon.svg"){
                    $(content).slideDown();
                    var pathImg = $(id+" img").attr("src", "icons/chevron-up_icon.svg");
                } else{
                    $(content).slideUp();
                    var pathImg = $(id+" img").attr("src", "icons/chevron-down_icon.svg");
                }
            });
        });
    </script>
</body>
</html>