<?php
require_once __DIR__ . '/php/config.php';
if (!session_id()) {
    session_start();
}

$endereco = ($_GET['endereco'] ?? '');
$titulo = 'FateCalc - Calculadora para autocorreção';
$pagina = false;

if (!empty($endereco) || empty($_SESSION['FateCalc_menu'] ?? [])) {
    $conexao = mysqli_connect(...Config::banco);
    if (empty($_SESSION['FateCalc_menu'] ?? [])) {
        $sql = "SELECT m.idMenu, m.menu, m.icone, IFNULL(p.endereco, m.url) AS link FROM menus AS m
                LEFT JOIN paginas AS p ON p.idPagina = m.idPagina
                WHERE m.idMenuPai = 0
                ORDER BY m.ordem, m.menu";
        $menu = mysqli_query($conexao, $sql);
        $menus = [];
        if (mysqli_num_rows($menu)) {
            while ($linha = mysqli_fetch_assoc($menu)) {
                $sql = "SELECT m.idMenu, m.menu, m.icone, IFNULL(p.endereco, m.url) AS link FROM menus AS m
                        LEFT JOIN paginas AS p ON p.idPagina = m.idPagina
                        WHERE m.idMenuPai = {$linha['idMenu']}
                        ORDER BY m.ordem, m.menu";
                $submenu = mysqli_query($conexao, $sql);
                $submenus = [];
                if (mysqli_num_rows($submenu)) {
                    while ($linha2 = mysqli_fetch_assoc($submenu)) {
                        $submenus[] = $linha2;
                    }
                }
                $linha['submenus'] = $submenus;
                $menus[] = $linha;
            }
        }

        $_SESSION['FateCalc_menu'] = $menus;
    }
    if (!empty($endereco)) {
        $sql = "SELECT * FROM paginas WHERE endereco = '$endereco'";
        $pagina = mysqli_query($conexao, $sql);
        if (mysqli_num_rows($pagina)) {
            $pagina = mysqli_fetch_assoc($pagina);
            $title = "{$pagina['titulo']} - FateCalc";

            $sql = "SELECT * FROM formulas WHERE idPagina = {$pagina['idPagina']} ORDER BY ordem";
            $formula = mysqli_query($conexao, $sql);
            $formulas = [];
            if (mysqli_num_rows($formula)) {
                while ($linha = mysqli_fetch_assoc($formula)) {
                    $formulas[] = $linha;
                }
            }

            $sql = "SELECT * FROM variaveis WHERE idPagina = {$pagina['idPagina']} ORDER BY resultado, ordem";
            $variavel = mysqli_query($conexao, $sql);
            $variaveis = [];
            $variaveisResultados = [];
            if (mysqli_num_rows($variavel)) {
                while ($linha = mysqli_fetch_assoc($variavel)) {
                    if ($linha['resultado'] == 1) {
                        $variaveisResultados[] = $linha;
                    } else {
                        $variaveis[] = $linha;
                    }
                }
            }
        } else {
            $pagina = false;
        }
    }
}
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

    <title><?= $titulo ?></title>
    <?php if ($pagina) { ?>
        <script id="customScript">
            var formulas = <?php echo json_encode($formulas); ?>;

            function preTratamento() {
                <?= $pagina['preTratamento'] ?>
            }
        </script>
    <?php } ?>
</head>

<body>
    <nav class='navbar fixed-top navbar-expand-lg navbar-light bg-light'>
        <a class='navbar-brand' href='./'>FateCalc</a>
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>

        <div class='collapse navbar-collapse' id='navbarSupportedContent'>
            <ul class='navbar-nav mr-auto'>
                <?php
                foreach ($_SESSION['FateCalc_menu'] as $menu) {
                    if (empty($menu['submenus'])) {
                ?>
                        <li class='nav-item'>
                            <a class='nav-link' href='<?= $menu['link'] ?>'><?= (empty($menu['icone']) ? '' :  "<i class='fas fa-{$menu['icone']}'></i> ") . $menu['menu'] ?></a>
                        </li>
                    <?php } else { ?>
                        <li class='nav-item dropdown'>
                            <a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                <?= (empty($menu['icone']) ? '' :  "<i class='fas fa-{$menu['icone']}'></i> ") . $menu['menu'] ?>
                            </a>
                            <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                                <?php foreach ($menu['submenus'] as $submenu) { ?>
                                    <a class='dropdown-item' href='<?= $submenu['link'] ?>'><?= (empty($submenu['icone']) ? '' :  "<i class='fas fa-{$submenu['icone']}'></i> ") . $submenu['menu'] ?></a>
                                <?php } ?>
                            </div>
                        </li>
                <?php
                    }
                }
                ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <br>
        <?php if ($pagina) { ?>
            <h4 id="subtitulo"><?= $pagina['subtitulo'] ?></h4>
            <h1 id="titulo"><?= $pagina['titulo'] ?></h1>
            <?php foreach ($formulas as $formula) { ?>
                <h4 id="<?= $formula['varResultado'] ?>Formula">$$<?= $formula['varResultado'] ?> = <?= $formula['formulaTex'] ?>$$</h4>
            <?php } ?>
            <ul id="legenda">
                <?php foreach ($variaveis as $variavel) { ?>
                    <li><b><?= $variavel['variavelLabel'] ?></b> = <?= $variavel['descricao'] ?></li>
                <?php } ?>
                <br>
                <?php foreach ($variaveisResultados as $variavel) { ?>
                    <li><b><?= $variavel['variavelLabel'] ?></b> = <?= $variavel['descricao'] ?></li>
                <?php } ?>
            </ul>
            <br>
            <form onsubmit="calcular(event);">
                <div class="form-row">
                    <?php
                    $larguraLinha = 0;
                    foreach ($variaveis as $variavel) {
                        if ($larguraLinha + $variavel['largura'] > 12) {
                            $larguraLinha = 0;
                    ?>
                </div>
                <div class="form-row">
                <?php } ?>
                <div class="form-group col-md-<?= $variavel['largura'] ?>">
                    <?php if ($variavel['tipoValor'] == 0) { ?>
                        <label class="vazio">&nbsp;</label><br class="vazio">
                    <?php } ?>
                    <?php if ($variavel['periodo'] == 0) { ?>
                        <label class="vazio">&nbsp;</label><br class="vazio">
                    <?php } ?>
                    <?php if ($variavel['tipoValor'] == 1) { ?>
                        <input type="radio" id="<?= $variavel['variavel'] ?>Porc" name="<?= $variavel['variavel'] ?>Valor" value="P" <?= ($variavel['tipoValorPadrao'] == 'P' ? 'checked' : '') ?>> <label for="<?= $variavel['variavel'] ?>Porc">%</label>
                        <input type="radio" id="<?= $variavel['variavel'] ?>Real" name="<?= $variavel['variavel'] ?>Valor" value="R" <?= ($variavel['tipoValorPadrao'] == 'R' ? 'checked' : '') ?>> <label for="<?= $variavel['variavel'] ?>Real">$</label><br>
                    <?php } ?>
                    <?php if ($variavel['periodo'] == 1) { ?>
                        <input type="radio" id="<?= $variavel['variavel'] ?>Mensal" name="<?= $variavel['variavel'] ?>Periodo" value="M" <?= ($variavel['periodoPadrao'] == 'M' ? 'checked' : '') ?>> <label for="<?= $variavel['variavel'] ?>Mensal">Mensal</label>
                        <input type="radio" id="<?= $variavel['variavel'] ?>Anual" name="<?= $variavel['variavel'] ?>Periodo" value="A" <?= ($variavel['periodoPadrao'] == 'A' ? 'checked' : '') ?>> <label for="<?= $variavel['variavel'] ?>Anual">Anual</label>
                    <?php } ?>
                    <div class="input-group">
                        <div class="input-group-prepend" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= $variavel['descricao'] ?>">
                            <span class="input-group-text"><?= $variavel['variavelLabel'] . ($variavel['monetario'] ? ' $' : '') ?></span>
                        </div>
                        <input type="text" class="form-control" id="<?= $variavel['variavel'] ?>" data-casas="<?= $variavel['casas'] ?>" data-variavelTex="<?= $variavel['variavelTex'] ?>">
                    </div>
                </div>
            <?php
                        $larguraLinha += $variavel['largura'];
                    }
            ?>
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
                <?php foreach ($variaveisResultados as $variavel) { ?>
                    <h5 id="<?= $variavel['variavel'] ?>Resolucao"></h5>
                    <div class="form-row">
                        <?php if (floor((12 - $variavel['largura']) / 2)) { ?>
                            <div class="col-md-<?= floor((12 - $variavel['largura']) / 2) ?>">
                            </div>
                        <?php } ?>
                        <div class="form-group col-md-<?= $variavel['largura'] ?>">
                            <div class="input-group">
                                <div class="input-group-prepend" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= $variavel['descricao'] ?>">
                                    <span class="input-group-text"><?= $variavel['variavelLabel'] . ($variavel['monetario'] ? ' $' : '') ?></span>
                                </div>
                                <input type="text" class="form-control" id="<?= $variavel['variavel'] ?>" data-casas="<?= $variavel['casas'] ?>" data-variavelTex="<?= $variavel['variavelTex'] ?>" disabled>
                            </div>
                        </div>
                        <?php if (ceil((12 - $variavel['largura']) / 2)) { ?>
                            <div class="col-md-<?= ceil((12 - $variavel['largura']) / 2) ?>">
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </form>
        <?php } ?>
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