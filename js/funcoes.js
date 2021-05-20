window.onload = function () {
    let inputs = $('form input');
    for (let i = 0; i < inputs.length; ++i) {
        if (inputs[i].type == 'text') {
            inputs[i].mask = IMask(inputs[i], {
                mask: Number,
                scale: inputs[i].getAttribute('data-casas') * 1,
                signed: (inputs[i].getAttribute('data-negativo') == 1),
                thousandsSeparator: (inputs[i].getAttribute('data-monetario') == 1 ? '.' : ''),
                padFractionalZeros: (inputs[i].getAttribute('data-monetario') == 1),
                mapToRadix: []
            });
            inputs[i].addEventListener('input', limparFormula);
        } else {
            inputs[i].addEventListener('change', limparFormula);
        }
    }
};

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

function calcular(event = false) {
    if (event) {
        event.preventDefault();
    }
    if (typeof preTratamento == 'function') {
        preTratamento();
    }
    let campos = $('form input[type=text]');
    let escopo = {};
    let formulasTemp = JSON.parse(JSON.stringify(formulas));
    for (let i = 0; i < campos.length; ++i) {
        escopo[campos[i].id] = campos[i].mask.typedValue;
        let valorMensal = campos[i].mask.typedValue;
        let valorAnual = campos[i].mask.typedValue;

        let campoPeriodo = document.forms[0].elements[campos[i].id + 'Periodo'];
        if (campoPeriodo) {
            if (campoPeriodo.value == 'M') {
                valorAnual *= 12;
            } else {
                valorMensal /= 12;
            }
            escopo[campos[i].id + 'mensal'] = valorMensal;
            escopo[campos[i].id + 'anual'] = valorAnual;
        }

        if (campos[i].mask.value != '') {
            let busca = new RegExp(' ' + escapeRegExp(campos[i].getAttribute('data-variaveltex')) + ' ', 'g');
            let buscaMensal;
            let buscaAnual;
            if (campoPeriodo) {
                buscaMensal = new RegExp(' ' + escapeRegExp(campos[i].getAttribute('data-variaveltex')) + '\_\{mensal\} ', 'g');
                buscaAnual = new RegExp(' ' + escapeRegExp(campos[i].getAttribute('data-variaveltex')) + '\_\{anual\} ', 'g');
            }
            for (let j = 0; j < formulasTemp.length; ++j) {
                formulasTemp[j].formulaTex = formulasTemp[j].formulaTex.replace(busca, ' ' + campos[i].mask.value + ' ');
                if (campoPeriodo) {
                    formulasTemp[j].formulaTex = formulasTemp[j].formulaTex.replace(buscaMensal, ' ' + valorMensal.toString().replace('.', ',') + ' ');
                    formulasTemp[j].formulaTex = formulasTemp[j].formulaTex.replace(buscaAnual, ' ' + valorAnual.toString().replace('.', ',') + ' ');
                }
            }
        }
    }
    for (let i = 0; i < formulasTemp.length; ++i) {
        let resultado = math.evaluate(formulasTemp[i].formula, escopo);
        if ($('#' + formulasTemp[i].varResultado)[0].getAttribute('data-casas') * 1 == 0) {
            resultado = parseInt(resultado);
        }
        $('#' + formulasTemp[i].varResultado)[0].mask.unmaskedValue = resultado.toString();

        if ($('#' + formulasTemp[i].varResultado)[0].mask.value != '') {
            $('#' + formulasTemp[i].varResultado + 'Resolucao')[0].innerHTML = '$$' + formulasTemp[i].varResultadoTex + ' = ' + formulasTemp[i].formulaTex + ' = ' + $('#' + formulasTemp[i].varResultado)[0].mask.value + ' $$';
            MathJax.typeset();
        }

        escopo[formulasTemp[i].varResultado] = $('#' + formulasTemp[i].varResultado)[0].mask.typedValue;

        let busca = new RegExp(' ' + escapeRegExp(formulasTemp[i].varResultadoTex) + ' ', 'g');
        for (let j = i; j < formulasTemp.length; ++j) {
            formulasTemp[j].formulaTex = formulasTemp[j].formulaTex.replace(busca, ' ' + $('#' + formulasTemp[i].varResultado)[0].mask.value + ' ');
        }
    }
}

function limparFormula() {
    for (let i = 0; i < formulas.length; ++i) {
        $('#' + formulas[i].varResultado)[0].mask.unmaskedValue = '';
        $('#' + formulas[i].varResultado + 'Resolucao')[0].innerHTML = '';
    }
}

function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}