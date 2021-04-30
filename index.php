<?php
require_once __DIR__ . '/php/config.php';
?>
<!doctype html>
<html lang="pt">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="css/estilos.css">

    <!-- favicon -->
    <link rel="shortcut icon" href="img/favicon.png">

    <!-- Font Awesome JS -->
    <script src="fontawesome/js/all.min.js"></script>

    <title>FateCalc - Calculadora para autocorreção de exercícios matemáticos da Fatec</title>
    <script>

    </script>
</head>

<body>
    <div class="container">
        <br>
        <h4>Sistemas de Gestão de Produção e Logística</h4>
        <h1>Lote Econômico de Compra</h1>
        <br>
        <form>
            <div class="mb-3">
                <label for="D" class="form-label">Consumo médio anual</label>
                <input type="text" class="form-control" id="D" value="4500">
            </div>
            <div class="mb-3">
                <label for="cp" class="form-label">Custo de aquisição/ordem/pedido</label>
                <input type="text" class="form-control" id="cp" value="225">
            </div>
            <div class="mb-3">
                <label for="i" class="form-label">Taxa de juros ou custo de manutenção ou custo de armazenagem/estocagem</label>
                <input type="text" class="form-control" id="i" value="0.25">
            </div>
            <div class="mb-3">
                <label for="v" class="form-label">Custo/valor unitário</label>
                <input type="text" class="form-control" id="v" value="40">
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-primary" onclick="calcular()">Calcular</button>
            </div>
        </form>
        <div class="mb-3">
            <label for="resultado" class="form-label">Resultado</label>
            <input type="text" class="form-control" id="resultado" disabled>
        </div>
        <br>
        <!-- Footer -->
        <!-- Copyright -->
        <?= Config::rodape(); ?>
    </div>

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- JS -->
    <script src="js/math.js"></script>
    <script src="js/funcoes.js?=<?= Config::atualizacao ?>"></script>
</body>

</html>