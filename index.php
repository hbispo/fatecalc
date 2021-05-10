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
        <p>
        <ul>
            <li>D = Consumo médio</li>
            <li>cp = Custo de aquisição/ordem/pedido</li>
            <li>i = Taxa de juros ou custo de manutenção ou custo de armazenagem/estocagem</li>
            <li>v = Custo/valor unitário</li>
        </ul>
        </p>
        <br>
        <form>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-prepend" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Consumo médio">
                            <span class="input-group-text">D</span>
                        </div>
                        <input type="text" class="form-control" id="D" value="4500">
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-prepend" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Custo de aquisição/ordem/pedido">
                            <span class="input-group-text">cp</span>
                        </div>
                        <input type="text" class="form-control" id="cp" value="225">
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-prepend" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Taxa de juros ou custo de manutenção ou custo de armazenagem/estocagem">
                            <span class="input-group-text">i</span>
                        </div>
                        <input type="text" class="form-control" id="i" value="0.25">
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-prepend" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Custo/valor unitário">
                            <span class="input-group-text">v</span>
                        </div>
                        <input type="text" class="form-control" id="v" value="40">
                    </div>
                </div>
                <div class="form-group col-md-2" style="text-align: center;">
                    <button type="button" class="btn btn-primary" onclick="calcular()">Calcular</button>
                </div>
                <div class="form-group col-md-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">=</span>
                        </div>
                        <input type="text" class="form-control" id="resultado" disabled>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <!-- Copyright -->
    <?= Config::rodape(); ?>

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- JS -->
    <script src="js/math.js"></script>
    <script src="js/funcoes.js?=<?= Config::atualizacao ?>"></script>
</body>

</html>