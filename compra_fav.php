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
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php if ($num == 0) { ?>
    <div class="warning-text"><p>Seus locais salvos aparecerão aqui.</p></div>
    <?php
    } else{ 
        while ($dados = $salvos->fetch(PDO::FETCH_ASSOC)) {
    ?>

    <div class="saved-content">
        <div class="card-container">
            <div class="card-head">
                <p><?php echo $dados['nome_farmacia'] ?></p>
                <form action="" method="post">
                    <input type="hidden" name="idFav" value="<?= $dados['id_favorito'] ?>">
                    <button name="remover"><img src="icons/bookmark-remove_icon.svg" alt=""></button>
                </form>
            </div>
            <div class="card-body">
                <div>
                    <img src="icons/map-marker_icon.svg" alt="">
                    <img src="icons/dot_icon.svg" alt="">
                    <p><?php echo $dados['endereco'] ?></p>
                </div>
                <div>
                    <img src="icons/phone_icon.svg" alt="">
                    <img src="icons/dot_icon.svg" alt="">
                    <p><?php echo $dados['tel_farmacia'] ?></p>
                </div>
                <div>
                    <img src="icons/clock-time_icon.svg" alt="">
                    <img src="icons/dot_icon.svg" alt="">
                    <p><span><?php echo $dados['situacao']; ?></span><?php echo " - ".$dados['fechamento']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php }} ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        
    </script>
</body>
</html>