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
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="info-medicine">
        <div class="medicine-atributes">
            <p><?php echo $medRes['nome_med']; ?></p>
            <p><?php echo $identRes['descricao']; ?></p>
            <div>
                <p>Receituário:</p>
                <p><?php echo " ".$receiRes['descricao']; ?></p>
            </div>
        </div>
        <div class="medicine-presentation">
            <div>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem facilis recusandae non libero incidunt quae temporibus hic ut aliquid velit, alias itaque quia, consequatur ratione vitae fuga eveniet eaque? Eligendi.
                    Magnam blanditiis minus consequuntur cum hic! Voluptatum temporibus illum rerum molestias accusamus deserunt vel fugit totam delectus maxime ea harum cum quo tempore architecto, nihil perferendis. Pariatur cum ex neque.
                    Nam molestias ab eligendi sit natus! Veniam quidem temporibus obcaecati eos, veritatis sed sequi, odio odit doloremque beatae officiis quasi, aliquid quis repudiandae. Explicabo, architecto. Nulla accusantium dolorem nihil asperiores.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
