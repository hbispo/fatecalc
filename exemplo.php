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

    <!-- MathJax JS -->
    <script src="node_modules/mathjax/es5/tex-chtml.js" id="MathJax-script" async></script>

    <!-- IMask JS -->
    <script src="js/imask.js"></script>

    <title>FateCalc - Calculadora para autocorreção de exercícios matemáticos da Fatec</title>
    <script id="customScript">
        var formulas = [{
            varResultado: 'LEC',
            formula: 'sqrt((2 * D * cp) / (i * v))',
            formulaTex: '\\sqrt{ 2 * D * cp \\over i * v }'
        }];

        function preTratamento() {
            if (document.forms[0].elements.DPeriodo.value != document.forms[0].elements.iPeriodo.value) {
                if (document.forms[0].elements.iPeriodo.value == 'M') {
                    $('#D')[0].mask.unmaskedValue = ($('#D')[0].mask.typedValue / 12).toString();
                } else {
                    $('#D')[0].mask.unmaskedValue = ($('#D')[0].mask.typedValue * 12).toString();
                }
                document.forms[0].elements.DPeriodo.value = document.forms[0].elements.iPeriodo.value;
            }
            if (document.forms[0].elements.iValor.value == 'P') {
                if ($('#i')[0].mask.typedValue > 1) {
                    $('#i')[0].mask.unmaskedValue = ($('#i')[0].mask.typedValue / 100).toString();
                }
            } else {
                $('#i')[0].mask.unmaskedValue = ($('#i')[0].mask.typedValue / $('#v')[0].mask.typedValue).toString();
                document.forms[0].elements.iValor.value = 'P';
            }
            return;
        }
    </script>
</head>

<body>
    <div class="container">
        <br>
        <h4 id="subtitulo">Sistemas de Gestão de Produção e Logística</h4>
        <h1 id="titulo">Lote Econômico de Compra</h1>
        <h4 id="LECFormula">$$LEC = \sqrt{2 * D * cp \over i * v }$$</h4>
        <ul id="legenda">
            <li><b>D</b> = Demanda ou consumo médio</li>
            <li><b>cp</b> = Custo de aquisição/ordem/pedido</li>
            <li><b>i</b> = Taxa de juros ou custo de manutenção ou custo de armazenagem/estocagem</li>
            <li><b>v</b> = Custo/valor unitário</li>
        </ul>
        <br>
        <form onsubmit="calcular(event);">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label class="vazio">&nbsp;</label><br class="vazio">
                    <input type="radio" id="DMensal" name="DPeriodo" value="M" checked> <label for="DMensal">Mensal</label>
                    <input type="radio" id="DAnual" name="DPeriodo" value="A"> <label for="DAnual">Anual</label>
                    <div class="input-group">
                        <div class="input-group-prepend" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Demanda ou consumo médio">
                            <span class="input-group-text">D</span>
                        </div>
                        <input type="text" class="form-control" id="D" value="4500" data-casas="2" required>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label class="vazio">&nbsp;</label><br class="vazio">
                    <label class="vazio">&nbsp;</label>
                    <div class="input-group">
                        <div class="input-group-prepend" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Custo de aquisição/ordem/pedido">
                            <span class="input-group-text">cp $</span>
                        </div>
                        <input type="text" class="form-control" id="cp" value="225" data-casas="2" required>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <input type="radio" id="iPorc" name="iValor" value="P" checked> <label for="iPorc">%</label>
                    <input type="radio" id="iReal" name="iValor" value="R"> <label for="iReal">$</label><br>
                    <input type="radio" id="iMensal" name="iPeriodo" value="M" checked> <label for="iMensal">Mensal</label>
                    <input type="radio" id="iAnual" name="iPeriodo" value="A"> <label for="iAnual">Anual</label>
                    <div class="input-group">
                        <div class="input-group-prepend" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Taxa de juros ou custo de manutenção ou custo de armazenagem/estocagem">
                            <span class="input-group-text">i</span>
                        </div>
                        <input type="text" class="form-control" id="i" value="25" data-casas="3" required>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label class="vazio">&nbsp;</label><br class="vazio">
                    <label class="vazio">&nbsp;</label>
                    <div class="input-group">
                        <div class="input-group-prepend" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Custo/valor unitário">
                            <span class="input-group-text">v $</span>
                        </div>
                        <input type="text" class="form-control" id="v" value="40" data-casas="2" required>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4">
                </div>
                <div class="form-group col-md-4" style="text-align: center;">
                    <button id="btCalcular" class="btn btn-primary">Calcular</button>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <h5 id="LECResolucao"></h5>
            <div class="form-row">
                <div class="col-md-4">
                </div>
                <div class="form-group col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Lote Econômico de Compra">
                            <span class="input-group-text">LEC</span>
                        </div>
                        <input type="text" class="form-control" id="LEC" disabled>
                    </div>
                </div>
                <div class="col-md-4">
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