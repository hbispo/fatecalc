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
    let formulaResolucao = formulaTex;
    for (let i = 0; i < campos.length; ++i) {
        escopo[campos[i].id] = campos[i].mask.typedValue;

        let busca = new RegExp(' ' + campos[i].id + ' ', 'g');
        formulaResolucao = formulaResolucao.replace(busca, ' ' + campos[i].mask.value + ' ');
    }
    if (typeof preCalcular == 'function') {
        escopo = preCalcular(escopo);
    }
    let resultado = math.evaluate(formula, escopo);
    if ($('#resultado')[0].getAttribute('data-casas') * 1 == 0) {
        resultado = parseInt(resultado);
    }
    $('#resultado')[0].mask.unmaskedValue = resultado.toString();

    $('#formulaResolucao')[0].innerHTML = '$$' + varResultado + ' = ' + formulaResolucao + ' = ' + $('#resultado')[0].mask.value + ' $$';
    MathJax.typeset();
}

function limparFormula() {
    $('#resultado').val('');
    $('#formulaResolucao')[0].innerHTML = '';
}