window.onload = function () {
    let inputs = $('form input');
    for (let i = 0; i < inputs.length; ++i) {
        if (inputs[i].type == 'text') {
            inputs[i].mask = IMask(inputs[i], {
                mask: Number,
                scale: inputs[i].getAttribute('data-casas') * 1,
                signed: (inputs[i].getAttribute('data-negativo') == 1),
                mapToRadix: []
            });
            inputs[i].addEventListener('keydown', limparFormula);
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
    let formulasTemp = formulas.slice();
    for (let i = 0; i < campos.length; ++i) {
        escopo[campos[i].id] = campos[i].mask.typedValue;

        let busca = new RegExp(' ' + campos[i].id + ' ', 'g');
        for (let j = 0; j < formulasTemp.length; ++j) {
            formulasTemp[j].formulaTex = formulasTemp[j].formulaTex.replace(busca, ' ' + campos[i].mask.value + ' ');
        }
    }
    for (let i = 0; i < formulasTemp.length; ++i) {
        let resultado = math.evaluate(formulasTemp[i].formula, escopo);
        if ($('#' + formulasTemp[i].varResultado)[0].getAttribute('data-casas') * 1 == 0) {
            resultado = parseInt(resultado);
        }
        $('#' + formulasTemp[i].varResultado)[0].mask.unmaskedValue = resultado.toString();

        if ($('#' + formulasTemp[i].varResultado)[0].mask.value != '') {
            $('#' + formulasTemp[i].varResultado + 'Resolucao')[0].innerHTML = '$$' + formulasTemp[i].varResultado + ' = ' + formulasTemp[i].formulaTex + ' = ' + $('#' + formulasTemp[i].varResultado)[0].mask.value + ' $$';
            MathJax.typeset();
        }

        escopo[formulasTemp[i].varResultado] = $('#' + formulasTemp[i].varResultado)[0].mask.typedValue;

        let busca = new RegExp(' ' + formulasTemp[i].varResultado + ' ', 'g');
        for (let j = i; j < formulasTemp.length; ++j) {
            formulasTemp[j].formulaTex = formulasTemp[j].formulaTex.replace(busca, ' ' + $('#' + formulasTemp[i].varResultado)[0].mask.value + ' ');
        }
    }
}

function limparFormula() {
    for (let i = 0; i < formulas.length; ++i) {
        $('#' + formulas[i].varResultado).val('');
        $('#' + formulas[i].varResultado + 'Resolucao')[0].innerHTML = '';
    }
}